<?php
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $id string */
/** @var $services stdClass[] See Payment::getServices() */
/** @var $action string */
/** @var $popup bool */
/** @var $assetBundle string Alias to AssetBundle */

Yii::createObject(['class' => $assetBundle])->register($this);
// Open the payment dilalog in popup window.
if ($popup) {
    $options = [];
    foreach ($services as $name => $service) {
        $options[$service->id] = $service->jsArguments;
    }
    $this->registerJs('$("#' . $id . '").payment(' . json_encode($options) . ');');
}
?>
<div class="payment" id="<?php echo $id; ?>">
    <ul class="payment-list">
        <?php
        foreach ($services as $name => $service) {
            echo '<li class="payment-service payment-service-id-' . $service->id . '">';
            echo Html::a($service->title, [$action, 'service' => $name], [
                'class' => 'payment-service-link',
                'data-payment-service' => $service->id,
            ]);
            echo '</li>';
        }
        ?>
    </ul>
</div>