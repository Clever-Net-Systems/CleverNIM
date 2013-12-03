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

Your nodes should start to appear in your CleverNIM Web interface (the default admin login is "admin" with password "password").

* Create the following script as /etc/puppet/clevernim and chmod it to 755 (replace "http://clevernim.example.com" with the URL of your Clevernim instance):
#!/bin/bash
/usr/bin/curl -d certname=$1 http://clevernim.example.com/tag/ENC

* Add the following lines to your puppet.conf in the [master] section and restart Puppet:
node_terminus = exec
external_nodes = /etc/puppet/clevernim

You should now be able to assign tags to nodes via the Web interface.

OPTIONAL ELEMENTS
-----------------

* To get thumbnail generation in the Media Manager, you need to install php5-imagick

* To get OLAP data analysis on your nodes' facts, copy the folders saiku/ and saiku-ui/ to your Tomcat 7 webapps folder and point the URL in views/bi/olap.php to your Tomcat instance.
Modify saiku/WEB-INF/classes/saiku-datasources/mondrian and point the DB connection URL to your Clevernim MySQL instance

* To setup the software inventory system, deploy the puppet-inventory module in puppet-inventory/ to your nodes. Click on Admin > Generate inventory.

* To setup search with Solr, copy the solr/ folder to your Tomcat 7 webapps folder and move the solr subfolder to /var/lib/tomcat7/. You should end up with a solr folder in /var/lib/tomcat7/ and a solr folder in /var/lib/tomcat7/webapps/
Adjust the DB URL in solr/collection1/conf/clevernim.xml to point to your CleverNIM MySQL instance
Restart Tomcat
Click on Admin > Search options > Reindex search database
