<?php

    // redirect function:
    // function go to previous page or index page
    function redirectPage($page = NULL,$time = '3'){
        echo '<div class="alert alert-info">the page will redirect to ';
        if($page == NULL || !isset($_SERVER['HTTP_REFERER'])){
            echo 'Home page in '.$time.' second</div>';
            header("refresh:$time;url=index.php");
        }else{
            $page = $_SERVER['HTTP_REFERER'];
            echo 'Previous page in '.$time.' second</div>';
            header("refresh:$time;url=$page");
        }
        exit();
    }
    // function for all queries v1.0
    // v1.1 add negative values !=

    function query($type,$table,$props,$values = NULL,$wprops = NULL,$orderBy = NULL,$order = 'ASC',$limit = NULL){
        global $pdo;

        

        try{
            if($type == 'select'){
                // get the columns 
                $select = '';
                foreach($props as $prop){
                    $select .=$prop.',';
                }
                $select = substr_replace($select,' ',-1);
                // get the where conditions columns
                $where = NULL;
                if($wprops){
                    $where = '';
                    foreach($wprops as $wprop){
                        if($wprop[0] == '!'){
                            $wprop = substr($wprop,1);
                            $where .=$wprop.' !=? AND ';
                        }
                        else{
                            $where .=$wprop.' =? AND ';
                        }
                    }
                    $where = 'WHERE '.substr_replace($where,' ',-4);
                }
                // order by
                if($orderBy){
                    $orderBy = "ORDER BY $orderBy $order";
                }
                if($limit){
                    $limit = "LIMIT $limit";
                }
                // get the query
                $query = $pdo->prepare("SELECT $select  FROM $table $where $orderBy $limit");
                $query->execute($values);
                return $query;
            }elseif ($type == 'insert'){
                $columns = '';
                $vals = '';
                foreach($props as $prop){
                    $columns.=$prop.',';
                    $vals .='?,';
                }
                $columns = substr_replace($columns,' ',-1);
                $vals = substr_replace($vals,' ',-1);
                $query = $pdo->prepare("INSERT INTO $table ($columns) VALUES ($vals)");  
                $query->execute($values);
                echo '<div class="alert alert-success">'.lang('Info added with success').'</div>';
            }elseif($type == 'update'){
                $set = 'SET ';
                foreach($props as $prop){
                    $set .=$prop.' =?, ';
                }
                $set = substr_replace($set,' ',-2);
                $where = NULL;
                if($wprops){
                    $where = 'WHERE ';
                    foreach($wprops as $wprop){
                        $where .= $wprop.' = ? AND ';
                    }
                    $where = substr_replace($where,' ',-4);
                }
                $query = $pdo->prepare("UPDATE $table $set $where");
                $query->execute($values);
                echo '<div class="alert alert-success">'.lang('Info updated with success').'</div>';
            }elseif($type == 'delete'){
                $columns = 'WHERE ';
                foreach($props as $prop){
                    $columns.=$prop.' =? AND ';
                }
                $columns = substr_replace($columns,' ',-4);
                $query = $pdo->prepare("DELETE FROM $table $columns ");
                $query->execute($values);
                echo '<div class="alert alert-success">'.lang('Info delete with success').'</div>';
            }
        }catch(PDOException $e){
            if(str_contains($e->getMessage(),'Duplicate entry')){
                if(str_contains($e->getMessage(),'Username')){
                    echo '<div class="alert alert-danger">'.lang('Username has been used').'</div>';
                    return false;
                }if(str_contains($e->getMessage(),'Email')){
                    echo '<div class="alert alert-danger">'.lang('Email has been used').'</div>';
                    return false;
                }
            }
        }
    }
    // array of all countrie
    $countries = array(
        'Afghanistan', 'Akrotiri', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Ashmore and Cartier Islands', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Bassas de India', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswanna', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Clipperton Island', 'Cocoas (Keeling) Islands', 'Colombia', 'Comoros', 'Congo (Democratic Republic)', 'Congo (Republic)', 'Cook Islands', 'Coral Sea Islands', 'Costa Rica', 'Cote lvoire', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Dhekelia', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Europa Island', 'Falkland Islands (Islas Malvinas)', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guinea', 'French Polynesia', 'French Southern and Antarctic Lands', 'Gabon', 'Gambia', 'Gaza Strip', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Glorioso Islands', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard Island and McDonald Islands', 'Holy See (Vatican City)', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Jan Mayen', 'Japan', 'Jersey', 'Jordan', 'Juan de Nova Island', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea (North)', 'Korea (South)', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia (Federated States)', 'Moldova', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru', 'Navassa Island', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paracel Islands', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia and Montenegro', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia and the South Sandwich Islands', 'Spain', 'Spratly Islands', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tromelin Island', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Virgin Islands', 'Wake Island', 'Wallis and Futuna', 'West Bank', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'
        );
?>