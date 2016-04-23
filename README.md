# OCWrapper
A simple wrapper around the OCTranspo API.

##Include OCWrapper

`include('OCWrapper.php');`

##Create OCWrapper object

    $oc = new OCWrapper(array(
        'appid' => 'OC Tranpo app id',
        'apikey' => 'OC Tranpo api key',
        'http' => 'http://www.octranspo1.com'
    ));

Note: 
* The `http` key is only necessary if you're using a custom OC Transpo API address
* The `options` parameter is optional. The default `format` is JSON and `returnArray` is true

###GetRouteSummaryForStop

Retrieves the routes for a given stop number

    $data = array(
        'routeNo' => '95',
        'stopNo' => '3000'
    );
    $options = array(
        'format' => 'json',
        'returnArray' => true
    );
    $oc->GetRouteSummaryForStop($data, $options);

###GetNextTripsForStop

Retrieves next three trips on the route for a given stop number

    $data = "3000";
    $options = array(
        format => 'json',
        returnArray => true
    );
    $oc->GetNextTripsForStop($data, $options);

###GetNextTripsForStopAllRoutes

Retrieves next three trips for all routes for a given stop number

    $data = "3000";
    $options = array(
        format => 'json',
        returnArray => true
    );
    $oc->GetNextTripsForStopAllRoutes($data, $options);

###GTFS

Retrieves specific records from all sections the of GTFS file

* Refer to the official OC Transpo [API documentation](http://www.octranspo1.com/developers/documentation) for more information