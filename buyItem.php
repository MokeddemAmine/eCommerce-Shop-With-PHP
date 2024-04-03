<?php
    ob_start();
    session_start();
    $pageTitle = 'buyItem';
    include 'init.php';
    echo '<section class="buyItem mt-5">';
    echo '<div class="container">';

    $page = isset($_GET['do'])?$_GET['do']:'';

    
        if(isset($_SESSION['user'])){
            echo '<div class="row">';
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?$_GET['itemid']:0;
            $verifyItem = query('select','Items',['*'],[$itemid],['ItemID']);
            $item = NULL;
            if($page == 'payMethod'){
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    // info of payment 
                    $email          = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                    $units          = filter_var($_POST['number-of-item'],FILTER_SANITIZE_NUMBER_INT);

                    // info of customer 
                    $customer       = query('select','Users',['UserID'],[$_SESSION['user']],['Username'])->fetchObject()->UserID;
                    $customerPhone  = filter_var($_POST['customer-phone'],FILTER_SANITIZE_NUMBER_INT);
                    $customerCountry= filter_var($_POST['customer-country'],FILTER_SANITIZE_STRING);
                    $customerName   = filter_var($_POST['customer-name'],FILTER_SANITIZE_STRING);
                    $customerAddress= filter_var($_POST['customer-address'],FILTER_SANITIZE_STRING);
                    if(isset($_POST['visa']) || isset($_POST['mastercard'])){

                        // important : 
                        // these information must verify by their company , but we are just trying here because we havent business account to try it.
                        
                        $card_number    = filter_var($_POST['card-number'],FILTER_SANITIZE_NUMBER_INT);
                        $card_name      = filter_var($_POST['card-name'],FILTER_SANITIZE_STRING);
                        $card_expire_mo = filter_var($_POST['card-expire-month'],FILTER_SANITIZE_NUMBER_INT);
                        $card_expire_yr = filter_var($_POST['card-expire-year'],FILTER_SANITIZE_NUMBER_INT);
                        $cvv            = filter_var($_POST['card-cvv'],FILTER_SANITIZE_NUMBER_INT);
    
                        $formError = array();
    
                        if(empty($email)){
                            $formError[] = '<div class="alert alert">Please enter a valid email</div>';
                        }
                        if(strlen($card_number) != 16){
                            $formError[] = '<div class="alert alert">Please enter a valid Card Number</div>';
                        }
                        if(empty($card_name)){
                            $formError[] = '<div class="alert alert">Please enter a valid Name of Card</div>';
                        }
                        if($card_expire_mo < 1 || $card_expire_mo > 12){
                            $formError[] = '<div class="alert alert">Please enter a valid Month</div>';
                        }
                        if($card_expire_yr < 24 || $card_expire_yr > 30){
                            $formError[] = '<div class="alert alert">Please enter a valid Year of Card</div>';
                        }
                        if(strlen($cvv) > 3){
                            $formError[] = '<div class="alert alert">Please enter a valid CVV</div>';
                        }
                        if($units < 0){
                            $formError[] = '<div class="alert alert">Please enter a valid number of units</div>';
                        }
    
                        if(!empty($formError)){
                            foreach($formError as $error){
                                echo $error;
                            }
                        }
    
                        else{
                            echo '<div class="col-12">';
                            $addOrder = query('insert','Orders',['ItemID','CustomerID','CustomerName','Phone','Address','Quantity'],[$itemid,$customer,$customerName,$customerPhone,'Country: '.$customerCountry.'. Address: '.$customerAddress,$units],NULL,NULL,'ASC',NULL,'non');
                            echo '<div class="alert alert-success">Payment Success</div>';
                            
                            echo '</div>';
                        }
                    }elseif(isset($_POST['paypal'])){

                        $formError = array();
    
                        if(empty($email)){
                            $formError[] = '<div class="alert alert">Please enter a valid email</div>';
                        }
                        if($units < 0){
                            $formError[] = '<div class="alert alert">Please enter a valid number of units</div>';
                        }
                        if(!empty($formError)){
                            foreach($formError as $error){
                                echo $error;
                            }
                        }
    
                        else{
                            echo '<div class="col-12">';
                            $addOrder = query('insert','Orders',['ItemID','CustomerID','CustomerName','Phone','Address','Quantity'],[$itemid,$customer,$customerName,$customerPhone,'Country: '.$customerCountry.'. Address: '.$customerAddress,$units]);
                            echo '<div class="alert alert-success col-12">Payment Success</div>';
                            
                            echo '</div>';
                        }
                    }
                }
            }elseif($page == 'setAddress'){ 
                if($verifyItem->rowCount() > 0){
                    $item = $verifyItem->fetchObject();
            ?>
            
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-header bg-main-color text-second-color">
                            <h6 class="card-title text-capitalize">add a new address</h6>
                        </div>
                        <div class="card-body">
                            <form action="?do=payItem&itemid=<?= $itemid ?>" method="POST">
                                <div class="form-group">
                                    <select name="country" class="custom-select">
                                        <option hidden>Country/Region</option>
                                        <?php 
                                        foreach($countries as $country){
                                            echo '<option value="'.$country.'">'.$country.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Full Name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address1" placeholder="Street address, P.O. box, company name, c/o" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address2" placeholder="Apartment, suite, unit, building, floor, etc." class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="city" placeholder="City" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="state" placeholder="State / Province / Region" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="zipcode" placeholder="Zip Code" class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend col-3">
                                            <select name="codecountry" class="custom-select" id="country-code">
                                                
                                            </select>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" name="phone" placeholder="Phone Number" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Next Step" class="btn btn-sm btn-block bg-main-color text-second-color">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            <?php
            }else{
                echo '<div class="alert alert-danger">This Item doen\'t exist</div>';
                redirectPage();
            }
        }elseif($page == 'payItem'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $country        = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
                $name           = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
                $address        = filter_var($_POST['address1'],FILTER_SANITIZE_STRING).' '.filter_var($_POST['address2'],FILTER_SANITIZE_STRING).' '.filter_var($_POST['city'],FILTER_SANITIZE_STRING).' '.filter_var($_POST['state'],FILTER_SANITIZE_STRING).' '.filter_var($_POST['zipcode'],FILTER_SANITIZE_NUMBER_INT);
                $phone          = filter_var($_POST['codecountry'],FILTER_SANITIZE_NUMBER_INT).filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
                ?>
                <form style="display:none">
                    <input type="hidden" name="customer-country" id="customer-country" value="<?= $country ?>">
                    <input type="hidden" name="customer-name" id="customer-name" value="<?= $name ?>">
                    <input type="hidden" name="customer-address" id="customer-address" value="<?= $address ?>">
                    <input type="hidden" name="customer-phone" id="customer-phone" value="<?= $phone ?>">
                </form>
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <div class="card mb-3">
                        <div class="card-header bg-main-color text-second-color">
                            <h6 class="card-title text-capitalize">Address</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-striped">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-second-color">Name</td>
                                        <td><?= $name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-second-color">Address</td>
                                        <td><?= $address ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-second-color">Country</td>
                                        <td><?= $country ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-second-color">Phone</td>
                                        <td><?= $phone ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-main-color text-second-color">
                            <h6 class="card-title text-capitalize">payment solution</h6>
                        </div>
                        <div class="card-body">
                            <div class="click-payment visa bg-light d-flex align-items-center" data-class="visa" style="border-radius:2rem;cursor:pointer;">
                                <div class="img col-3">
                                    <img src="admin/imgs/visa.png" alt="visa card" class="w-100" style="height:100px;">
                                </div>
                                <p class="card-text col-6 text-capitalize m-0 bg-white h-100 py-5 font-weight-bold">pay with visa</p>
                                <div class="col-3 font-weight-bold">Select</div>
                            </div>
                            <div id="visa" class="method-payment bg-light p-5 my-3 mx-5 rounded" style="display:none;">
                                <form action="?do=payMethod&itemid=<?= $itemid ?>" method="POST" class="form-payment-method">
                                    <label class="text-capitalize text-second-color font-weight-bold">customer email</label>
                                    <input type="text" name="email" placeholder="Customer Email" class="form-control">
                                    <label class="text-capitalize text-second-color font-weight-bold">credit card number</label>
                                    <input type="text" name="card-number" placeholder="Credit Card Number" class="form-control">
                                    <label class="text-capitalize text-second-color font-weight-bold">card holder name</label>
                                    <input type="text" name="card-name" placeholder="Name as in Card" id="" class="form-control">
                                    <label class="text-capitalize text-second-color font-weight-bold">expiry date of card</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="card-expire-month" class="custom-select">
                                                <option hidden>Month</option>
                                                <option value="1">Jan</option>
                                                <option value="2">Feb</option>
                                                <option value="3">Mar</option>
                                                <option value="4">Apr</option>
                                                <option value="5">May</option>
                                                <option value="6">Jun</option>
                                                <option value="7">Jul</option>
                                                <option value="8">Aug</option>
                                                <option value="9">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select name="card-expire-year" class="custom-select">
                                                <option hidden>Year</option>
                                                <option value="24">2024</option>
                                                <option value="25">2025</option>
                                                <option value="26">2026</option>
                                                <option value="27">2027</option>
                                                <option value="28">2028</option>
                                                <option value="29">2029</option>
                                                <option value="30">2030</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="text-capitalize text-second-color font-weight-bold">card CVV</label>
                                    <input type="text" name="card-cvv" placeholder="CVV" maxlength="3" class="form-control">
                                    <input type="submit" value="Proceed" name="visa" class="btn btn-sm btn-block bg-main-color text-second-color my-2">
                                </form>
                            </div>
                            <div class="click-payment mastercard bg-light d-flex align-items-center my-4" data-class="mastercard" style="border-radius:2rem;cursor:pointer;">
                                <div class="img col-3">
                                    <img src="admin/imgs/mastercard.jpg" alt="visa card" class="w-100" style="height:100px;">
                                </div>
                                <p class="card-text col-6 text-capitalize m-0 bg-white h-100 py-5 font-weight-bold">pay with mastercard</p>
                                <div class="col-3 font-weight-bold">Select</div>
                            </div>
                            <div id="mastercard" class="method-payment bg-light p-5 my-3 mx-5 rounded" style="display:none;">
                                <form action="?do=payMethod&itemid=<?= $itemid ?>" method="POST" class="form-payment-method">
                                    <label class="text-capitalize text-second-color font-weight-bold">customer email</label>
                                    <input type="text" name="email" placeholder="Customer Email" class="form-control">
                                    <label class="text-capitalize text-second-color font-weight-bold">credit card number</label>
                                    <input type="text" name="card-number" placeholder="Credit Card Number" class="form-control">
                                    <label class="text-capitalize text-second-color font-weight-bold">card holder name</label>
                                    <input type="text" name="card-name" placeholder="Name as in Card" id="" class="form-control">
                                    <label class="text-capitalize text-second-color font-weight-bold">expiry date of card</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="card-expire-month" class="custom-select">
                                                <option hidden>Month</option>
                                                <option value="1">Jan</option>
                                                <option value="2">Feb</option>
                                                <option value="3">Mar</option>
                                                <option value="4">Apr</option>
                                                <option value="5">May</option>
                                                <option value="6">Jun</option>
                                                <option value="7">Jul</option>
                                                <option value="8">Aug</option>
                                                <option value="9">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select name="card-expire-year" class="custom-select">
                                                <option hidden>Year</option>
                                                <option value="24">2024</option>
                                                <option value="25">2025</option>
                                                <option value="26">2026</option>
                                                <option value="27">2027</option>
                                                <option value="28">2028</option>
                                                <option value="29">2029</option>
                                                <option value="30">2030</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="text-capitalize text-second-color font-weight-bold">card CVV</label>
                                    <input type="text" name="card-cvv" placeholder="CVV" maxlength="3" class="form-control">
                                    <input type="submit" value="Proceed" name="mastercard" class="btn btn-sm btn-block bg-main-color text-second-color my-2">
                                </form>
                            </div>
                            <div class="click-payment paypal bg-light d-flex align-items-center" data-class="paypal" style="border-radius:2rem;cursor:pointer;">
                                <div class="img col-3">
                                    <img src="admin/imgs/paypal.png" alt="visa card" class="w-100" style="height:100px;">
                                </div>
                                <p class="card-text col-6 text-capitalize m-0 bg-white h-100 py-5 font-weight-bold">pay with paypal</p>
                                <div class="col-3 font-weight-bold">Select</div>
                            </div>
                            <div id="paypal" class="method-payment bg-light p-5 my-3 mx-5 rounded" style="display:none;">
                                <form action="?do=payMethod&itemid=<?= $itemid ?>" method="POST" class="form-payment-method">
                                    <label class="text-capitalize text-second-color font-weight-bold">customer email</label>
                                    <input type="text" name="email" placeholder="Customer Email" class="form-control">
                                    <input type="submit" value="Proceed" name="paypal" class="btn btn-sm btn-block bg-main-color text-second-color my-2">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                 if($verifyItem->rowCount() > 0){
                    if(!$item){
                        $item = $verifyItem->fetchObject();
                    }
                    
            ?>
            
                <div class="col-lg-3">
                     <div class="card">
                        <div class="card-header bg-second-color text-white">
                            <h6 class="card-title m-0">order summary</h6>
                        </div>
                        <div class="card-body bg-light">
                            <h7 class="text-dark">Customer</h7>
                            <p><?= $_SESSION['user'] ?></p>
                            <hr>
                            <h7 class="text-dark">Product</h7>
                            <p><?= $item->Name ?></p>
                            <hr>
                            <h7 class="text-dark">Payment</h7>
                            <div class="row d-flex align-items-center"><div class="col-5"><span id="unit-price-item"><?= $item->Price ?></span> <?= $item->Currency ?> *</div> <div class="col-5"><input type="number" name="number-of-item" value="1" id="number-unit-item" min="1" class="form-control"/></div></div>
                        </div>
                        <div class="card-footer bg-second-color text-white ">
                            <h6 class="card-title m-0 row justify-content-between">
                                <span>total</span>
                                <span> <span id="price-item"><?= $item->Price ?></span> <?= $item->Currency ?></span>
                            </h6>
                            
                        </div>
                     </div>                   
                </div>
                <?php } 
            }
        }else{
            redirectPage(NULL,0);
        }
           ?>
        </div>
        <?php
    }
    else{
        echo '<div class="alert alert-info">You must <a href="login.php?do=login">Login</a> to continue the order</div>'; 
     }
    
    
    
    echo '</div>';
    echo '</section>';
    include $template . 'footer.php';
    ?>
    <script>
        $(document).ready(function(){
            // country code phone
            $.ajax({
                method:'GET',
                url:'https://gist.githubusercontent.com/pickletoni/021e2e18e83f33d16fee5daa308e6a4e/raw/fc6fd9127efd12d97a3d39f38befc784d6bcbf22/countryPhoneCodes.json',
                success:function(data){
                    let result = JSON.parse(data);
                    result.map(r => {
                        $('#country-code').append('<option value="'+r.code+'">'+r.iso+' '+r.code+'</option>');
                    })
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            })
            // add number unit item to form when submited
            $('.form-payment-method').submit(function(e){
                let inputUnitValue = document.getElementById('number-unit-item').value;
                $('#customer-country').val()
                // add number of item
                var InputUnit = document.createElement('input');
                InputUnit.type = 'hidden';
                InputUnit.name = 'number-of-item';
                InputUnit.value = $('#number-unit-item').val();
                $(this).append(InputUnit);
                // add customer country of item
                InputUnit = document.createElement('input');
                InputUnit.type = 'hidden';
                InputUnit.name = 'customer-country';
                InputUnit.value = $('#customer-country').val();
                $(this).append(InputUnit);
                // add customer address of item
                InputUnit = document.createElement('input');
                InputUnit.type = 'hidden';
                InputUnit.name = 'customer-address';
                InputUnit.value = $('#customer-address').val();
                $(this).append(InputUnit);
                // add customer phone of item
                InputUnit = document.createElement('input');
                InputUnit.type = 'hidden';
                InputUnit.name = 'customer-phone';
                InputUnit.value = $('#customer-phone').val();
                $(this).append(InputUnit);
                // add customer name of item
                InputUnit = document.createElement('input');
                InputUnit.type = 'hidden';
                InputUnit.name = 'customer-name';
                InputUnit.value = $('#customer-name').val();
                $(this).append(InputUnit);

            })
        })
    </script>
    <?php
    ob_end_flush();
?>