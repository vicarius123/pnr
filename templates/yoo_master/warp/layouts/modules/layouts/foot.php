<?php

switch (count($modules)) {

	case 1:
		printf('<div class="grid-box width100 grid-h">%s</div>', $modules[0]);
		break;

	case 2:
		printf('<div class="grid-box width50 grid-h">%s</div>', $modules[0]);
		printf('<div class="grid-box width50 grid-h">%s</div>', $modules[1]);
		break;

	case 3:
		printf('<div class="grid-box width25 grid-h">%s</div>', $modules[0]);
		printf('<div class="grid-box width50 grid-h">%s</div>', $modules[1]);
		printf('<div class="grid-box width25 grid-h">%s</div>', $modules[2]);
		break;
		
	case 4:
		printf('<div class="grid-box width20 grid-h">%s</div>', $modules[0]);
		printf('<div class="grid-box width30 grid-h">%s</div>', $modules[1]);
		printf('<div class="grid-box width30 grid-h">%s</div>', $modules[2]);
		printf('<div class="grid-box width20 grid-h">%s</div>', $modules[3]);
		break;
		
	default:
		echo '<div class="grid-box width100 grid-h">Error: Only up to 3 modules are supported in this layout. If you need more add your own layout.</div>';

}