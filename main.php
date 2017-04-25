<?php
require "autoloader.php";
use Querdos\Lib\ECDH;

// creating key pair for alice and bob
$ecdh_alice = new ECDH(ECDH::SECP256K1);
$ecdh_bob   = new ECDH(ECDH::SECP256K1);

// computing secret
$ecdh_alice->computeSecret($ecdh_bob->getPublic());
$ecdh_bob->computeSecret($ecdh_alice->getPublic());

// checking that they share the same secret
if (0 == gmp_cmp($ecdh_bob->getSecret(), $ecdh_alice->getSecret())) {
    echo "Alice and Bob share the same secret" . PHP_EOL;
} else {
    echo "Alice and bob don't share the same secret" . PHP_EOL;
    die;
}

// Alice want to send bob a message
$message = <<<EOT
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam interdum massa nec libero semper, sed consequat ipsum dictum. Nulla sit amet enim eleifend, iaculis dui tristique, malesuada est. Vestibulum non neque in leo sagittis aliquet. Sed ultrices nunc a quam faucibus vestibulum. Maecenas nec elit at enim rutrum egestas non ut tortor. Ut tincidunt volutpat elit, ut consequat libero tincidunt pretium. Cras feugiat facilisis dolor eget dapibus. Suspendisse eget ligula lorem. Vivamus molestie massa sed dictum pulvinar.

Integer vitae cursus metus, nec iaculis ante. Nam finibus nulla id magna pharetra, vel eleifend ligula semper. Aliquam a semper elit, ut rutrum turpis. Fusce suscipit orci non lectus rutrum posuere. Aenean ut lectus nec ipsum mollis malesuada vitae in ex. Sed bibendum est sed neque fermentum, sit amet consectetur quam ultricies. Aliquam et molestie nunc. Integer elementum mollis facilisis. Ut feugiat placerat vulputate. Nam ultricies feugiat nisi. Quisque placerat iaculis enim eget efficitur. Praesent eget condimentum ante. Duis eget ante velit.

In hac habitasse platea dictumst. Aenean eu lacinia felis, non placerat eros. Proin fringilla tortor in ipsum tempus posuere. Pellentesque consequat mattis arcu sed tincidunt. Sed et leo pellentesque, semper diam eget, vehicula quam. Duis viverra turpis mi, a porta quam euismod a. Nullam nulla neque, finibus vitae suscipit vehicula, ullamcorper a tortor. Morbi ullamcorper diam lectus, id consequat velit hendrerit at. Aenean vulputate, urna sit amet ornare placerat, ipsum nibh pulvinar purus, congue accumsan nisi arcu eget turpis. In leo tellus, gravida in ligula ut, efficitur tristique tellus. Donec tempus tempus augue, in lobortis nunc. Nulla vulputate tortor sed turpis mattis pharetra. Ut vestibulum cursus neque. Nam pulvinar elit eu sodales vulputate. Cras et sapien et felis lobortis tempus. Integer in leo sapien.

Nulla rutrum elementum pretium. Aenean sollicitudin neque dolor, eget pretium turpis placerat at. Ut ac lorem ipsum. Mauris risus quam, feugiat a libero et, mollis auctor dui. Donec condimentum porta ultricies. Phasellus aliquam elit vehicula, volutpat sapien lacinia, iaculis dolor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer volutpat nisi sed lectus ullamcorper, id viverra lacus molestie. Duis at lacus turpis. Donec vehicula elementum lectus eu vestibulum. Cras elementum sed sapien nec sollicitudin. Nunc nec tortor a diam euismod malesuada eget sed nibh. Suspendisse porta mattis augue.

Proin aliquet in justo ac sodales. Aenean at diam ultrices, gravida libero in, tempus est. Donec sed sagittis diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla mollis tincidunt purus ullamcorper pharetra. Suspendisse sollicitudin, nibh ac feugiat rutrum, purus arcu imperdiet dolor, ornare tristique massa urna sit amet nunc. Donec congue rutrum maximus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Morbi finibus sollicitudin elit, eu tincidunt quam viverra vel. Maecenas dictum nisl ut luctus molestie. Curabitur rutrum lacus urna, at luctus nulla mattis et.
EOT;

$sign    = $ecdh_alice->signMessage($message);
$sigOK   = $ecdh_bob->verifySignature($sign, $ecdh_alice->getPublic(), $message);

if ($sigOK) {
    echo "Signature match." . PHP_EOL;
} else {
    echo "Invalid signature." . PHP_EOL;
}


