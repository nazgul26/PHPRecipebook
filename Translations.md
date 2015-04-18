# Translations
If you are interested in performing a translation here are some basic steps to follow:

* Install Poedit (http://poedit.net/).  This is an Open Source tool that will help in translations.
> Hint for Ubuntu installs:  sudo apt-get install poedit
* Open the <app dir>Locale/default.pot in Poedit and translate
* When done as in Locale\<lang code>\LC_MESSAGES\default.po

## Automating Translation
You can use Google API to automate the translation. This costs money though.
* Get https://github.com/OzzyCzech/potrans and Clone / Composer install it.
* Install Curl for PHP: sudo apt-get install php5-curl
* Setup your own Google API account
    - setup a payment method 
    - add Translate API 
    - Create a Web Access Key
