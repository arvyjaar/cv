GetHired
========================
GetHired is a demo application created during NFQ Academy. 
Main goal of this application - help job seekers and employers 
find each other in the most efficient way.
Keywords: php, symfony, doctrine, mysql, jQuery.

How to run this project?
--------------
  * git clone <project>
  * cd path/to/<project>
  * composer install 
  * config db parameters in app/config/parameters.yml
  * bin/console doctrine:database:create
  * bin/console doctrine:schema:update --force
  * If demo data needed: bin/console doctrine:fixtures:load