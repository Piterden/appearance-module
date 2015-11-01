<?php namespace Anomaly\AppearanceModule\Http\Controller\Admin;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\SettingsModule\Setting\Form\SettingFormBuilder;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Authorizer;

/**
 * Class PublicThemesController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\AppearanceModule\Http\Controller\Admin
 */
class PublicThemesController extends AdminController
{

    /**
     * Return the settings form for the public theme.
     *
     * @param SettingFormBuilder $settings
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function settings(SettingFormBuilder $settings, ThemeCollection $themes)
    {
        if ($theme = $themes->activeStandard()) {
            $settings->setOption('title', trans('module::message.active_theme', ['theme' => trans($theme->getName())]));
        }

        return $settings->render(config('streams::themes.standard.active'));
    }

    /**
     * Return the modal list of public themes.
     *
     * @param ThemeCollection $themes
     * @return \Illuminate\View\View
     */
    public function choose(ThemeCollection $themes)
    {
        $themes = $themes->standard();

        return view('module::ajax/public_themes', compact('themes'));
    }

    /**
     * Activate the chosen theme.
     *
     * @param SettingRepositoryInterface $settings
     * @param Authorizer                 $authorizer
     * @param                            $namespace
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function activate(SettingRepositoryInterface $settings, Authorizer $authorizer, $namespace)
    {
        if (!$authorizer->authorize('anomaly.module.appearance::admin_theme.change')) {

            $this->messages->error('streams::message.access_denied');

            return $this->redirect->to('admin/appearance');
        }

        $settings->set('streams::public_theme', $namespace);

        return redirect('admin/appearance');
    }
}
