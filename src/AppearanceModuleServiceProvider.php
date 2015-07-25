<?php namespace Anomaly\AppearanceModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class AppearanceModuleServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\AppearanceModule
 */
class AppearanceModuleServiceProvider extends AddonServiceProvider
{

    /**
     * The addon listeners.
     *
     * @var array
     */
    protected $listeners = [
        'Anomaly\Streams\Platform\Asset\Event\ThemeVariablesAreLoading' => [
            'Anomaly\AppearanceModule\Listener\LoadThemeVariables'
        ]
    ];

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'admin/appearance'       => 'Anomaly\AppearanceModule\Http\Controller\Admin\PublicThemesController@settings',
        'admin/appearance/admin' => 'Anomaly\AppearanceModule\Http\Controller\Admin\AdminThemesController@settings'
    ];

}
