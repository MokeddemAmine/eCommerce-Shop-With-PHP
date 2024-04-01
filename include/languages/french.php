<?php
    function lang($sentence){
        static $lang = array(
            'welcome'           => 'bienvenue',
            'go to admin'       => 'à l\'administrateur',
            'add item'          => 'ajouter un item',
            'logout'            => 'Se déconnecter',
            // long sentences
            'Username (8 character minimun)'    => 'Nom d\'utilisateur (8 caractères minimum)',
            'Password must be >= 8 characters'  => 'Le mot de passe doit contenir >= 8 caracteres',
            'Email must be valid'               => 'L\'email doit être valide',
            'Enter your full name'              => 'Entrez votre nom complet',
            'add your avatar here'              => 'ajoutez votre avatar ici',
            'Info added with success'           => 'Informations ajoutées avec succès ',
            'Info updated with success'         => 'Informations mises à jour avec succès ',
            'Username has been used'            => 'Le nom d\'utilisateur a été utilisé',
            'Email has been used'               => 'L\'e-mail a été utilisé',
            'Same password if you don\'t enter' => 'Même mot de passe si vous ne saisissez pas',
            'Info delete with success'          =>  'Informations supprimées avec succès ',
            'Search Categories or Items Here'   => ' Rechercher des catégories ou des articles ici  ',
            'Enter your comment to this product'=> 'Entrez votre commentaire sur ce produit',
            'add new images to item'            => 'ajouter de nouvelles images à l\'élément',
            'Name must be not empty'            => "Le nom ne doit pas être vide",
            'Username must be not empty'        => 'Le nom d\'utilisateur ne doit pas être vide',
            'email must be not empty'           => 'l\'e-mail ne doit pas être vide',
            'Name must has more than 3 characters'=> 'Le nom doit comporter plus de 3 caractères',
            'Username must has more than 7 characters'=> 'Le nom d\'utilisateur doit comporter plus de 7 caractères',
            'Passwrod must has more than 7 characters'=> 'Le mot de passe doit contenir plus de 7 caractères',
            'Enter A Valid Email'               => 'Entrer un email valide',
            'update informations'               => 'mettre à jour les informations',
            // login page
            'Registration'                      => 'Inscription',
            'login'                             => 'se connecter',
            'Enter your name here'              => 'Entrez votre nom ici',
            'Enter your username'               => 'Entrez votre nom d\'utilisateur',
            'Enter a valid email'               => 'Entrer un email valide',
            'Enter a password'                  => 'Entrer un mot de passe',
            'Repeat your password'              => 'Répétez votre mot de passe',
            'Sign up'                           => 'S\'inscrire',
            'Enter your username or email here' => 'Entrez votre nom d\'utilisateur ou votre email ici',
            'Enter your password'               => 'Tapez votre mot de passe',
            'You have an acount '               => 'Vous avez un compte',
            'You have not an acount'            => 'Vous n\'avez pas de compte',
            'Register'                          => 'Registre',

            // main page
            'click here'                        => 'Cliquez ici',
            'show more'                         => 'montre plus',

            // items page
            'item'                              => 'article',
            'items'                             => 'articles',
            'add new item'                      => 'Ajoute un nouvel objet',
            'Enter the title'                   => 'Entrez le titre',
            'Enter the description'             => 'Entrez la description',
            'Enter the price'                   => 'Entrez le prix',
            'Country Made'                      => 'Fabriqué dans le pays',
            'Status'                            => 'Statut',
            'new'                               => 'nouveau',
            'like new'                          => 'comme neuf',
            'used'                              => 'utilisé',
            'Category'                          => 'Catégorie',
            'Sub Category'                      => 'Sous-catégorie',
            'add images to item'                => 'ajouter des images à l\'article',
            'title here'                        => 'titre ici',
            'description here'                  => 'description ici',
            'show more images'                  => 'afficher plus d\'images',
            'name'                              => 'nom',
            'username'                          => 'nom d\'utilisateur',
            'email'                             => 'e-mail',
            'description'                       => 'description',
            'country'                           => 'pay',
            'price'                             => 'prix',
            'category'                          => 'categorie',
            'status'                            => 'statut',
            'added date'                        => 'date ajoutée',
            'edit'                              => 'modifier',
            'delete'                            => 'supprimer',
            'You have to'                       => 'Vous devez',
            'For Comment'                       => 'Pour commentaires',
            'comment'                           => 'commentaire',
            'comment date'                      => 'comment date',
            'edit item'                         => 'edit item',
            'delete item'                       => 'date du commentaire',

            // profile page

            'profile'                           => 'profil',
            'information'                       => 'information',
            'comments'                          => 'commentaire',
            'There are no comment'              => 'Il n\'y a pas de commentaire',
            'There are no item'                 => 'Il n\'y a aucun élément',

            // settings page
            'settings'                          => 'parametres',
            'full name'                         => 'nom complete',
            'password'                          => 'mot de pass',



        );
        return $lang[$sentence];
    }
?>