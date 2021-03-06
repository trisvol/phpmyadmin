<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Lists available transformation plugins
 *
 * @package PhpMyAdmin
 */
declare(strict_types=1);

use PhpMyAdmin\Response;
use PhpMyAdmin\Transformations;

if (! defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}

/**
 * Gets some core libraries and displays a top message if required
 */
require_once ROOT_PATH . 'libraries/common.inc.php';

$response = Response::getInstance();
$header   = $response->getHeader();
$header->disableMenuAndConsole();

$transformations = new Transformations();

$types = $transformations->getAvailableMimeTypes();
?>

<h2><?php echo __('Available MIME types'); ?></h2>
<?php
foreach ($types['mimetype'] as $key => $mimetype) {
    if (isset($types['empty_mimetype'][$mimetype])) {
        echo '<i>' , htmlspecialchars($mimetype) , '</i><br>';
    } else {
        echo htmlspecialchars($mimetype) , '<br>';
    }
}
$transformation_types = [
    'transformation', 'input_transformation'
];
$label = [
    'transformation' => __('Available browser display transformations'),
    'input_transformation' => __('Available input transformations')
];
$th = [
    'transformation' => __('Browser display transformation'),
    'input_transformation' => __('Input transformation')
];
?>
<br>
<?php foreach ($transformation_types as $ttype) { ?>
    <a name="<?php echo $ttype; ?>"></a>
    <h2><?php echo $label[$ttype] ?></h2>
    <table width="90%">
    <thead>
    <tr>
        <th><?php echo $th[$ttype] ?></th>
        <th><?php echo _pgettext('for MIME transformation', 'Description'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($types[$ttype] as $key => $transform) {
        $desc = $transformations->getDescription($types[$ttype . '_file'][$key]);
        ?>
        <tr>
            <td><?php echo htmlspecialchars($transform); ?></td>
            <td><?php echo htmlspecialchars($desc); ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    </table>
    <?php
} // End of foreach ($transformation_types)
