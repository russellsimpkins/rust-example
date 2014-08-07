<?PHP

require_once 'vendor/autoload.php';
use Example\Controller;

$controller = new Controller();
$controller->run('/svc/example/add/-10/-12.json');
$controller->run('/svc/example/add/10/12.json');

