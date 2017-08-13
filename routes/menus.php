<?php

declare(strict_types=1);

Menu::backendSidebar('resources')->routeIfCan('list-tags', 'backend.tags.index', '<i class="fa fa-tags"></i> <span>'.trans('cortex/taggable::common.tags').'</span>');
