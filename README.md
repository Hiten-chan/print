# Print
University project for course "Internet technologies" (SPbPU)

## <b>Description</b>
This system allows the client to create an order, which will then be processed by the operator. 
Full description and UML models you can find in <b>print/doc/</b> 


## <b>Installing</b>
1. The following should be installed:
- PHP (7.1 and higher)
- MySQL (5.5 and higher)

2. Expand the database using <b>/db/printdb.sql</b>
When the database is initialized, a user with administrator rights will be automatically created with the folow data:
login: admin
password: admin

3. In the /src/includes/constants.php file, change the server name, user name, password, and database name (if required).

4. All files for the service work are stored in the <b>src</b> folder.


## <b>Demo</b>
Demo version of the service - https://print8print.000webhostapp.com/
