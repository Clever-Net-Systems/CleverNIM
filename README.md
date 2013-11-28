CleverNIM
=========

A Web-based Puppet ENC for applying classes by tagging nodes

INSTALLATION
------------

* Deploy the contents of the archive in an Apache DocumentRoot

* Create a new MySQL database and import the contents of install/clevernim.sql:

mysql> create database clevernim;
mysql> grant all privileges on clevernim.\* to 'clevernim'@'localhost' identified by 'clevernim';
mysql> flush privileges;
mysql> use clevernim
mysql> \. install/clevernim.sql

* Configure config/main.php to point to your newly created MySQL instance
* Configure config/main.php to point to your PuppetDB instance

* Add the clevernim module in puppet-clevernim/ to your Puppet manifests

* Use Puppet to deploy the clevernim module to your nodes (replace "http://clevernim" with the URL of your Clevernim instance):
node default {
	class {'clevernim':
		server => 'http://clevernim',
	}
}

Your nodes should start to appear in your CleverNIM Web interface.

OPTIONAL ELEMENTS
-----------------


