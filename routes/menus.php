<?php

declare(strict_types=1);

Menu::adminareaSidebar('taxonomies')->routeIfCan('list-tags', 'adminarea.tags.index', '<i class="fa fa-tags"></i> <span>'.trans('cortex/tags::common.tags').'</span>');
