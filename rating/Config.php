<?php
    /**
     * $id$
     */

    class Config
    {
        //DATABASE CONFIGURATION
		const DBSERVER      = "127.0.0.1";      //sql100.byethost3.com //tabtabpics.db.4922896.hostedresource.com
        const DBPORT        = 3306;             //3306
		const DBNAME        = "jms_rating";         //b3_2576929_happy //tabtabpics
		const DBUSERNAME    = "root";           //b3_2576929 //tabtabpics
		const DBPASSWORD    = "";               //123456 //J@mes2011
        const DBPREFIX      = "";
        
        //Cookie Duration
        const COOKIETTL         = 3000;                //cookie time to live, in seconds
        const COOKIEDOMAIN      = "";                  //E.g. .cmsgp.org means all sub-domain of cmsgp.org can access
        const COOKIEONLYHTTP    = true;                //only be available for http, otherwise javascript can
        const COOKIEHTTPS       = false;               //transform in https

        //Data
        const UPLOAD_FOLDER      = "./upload/";  		//the image folder
		
		//mode
		const DEMO_MODE			= true;			//demo mode doesn't allow user to add/edit/delete products
    }
?>