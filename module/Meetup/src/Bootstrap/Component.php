<?php

declare(strict_types=1);

namespace Meetup\Bootstrap;

class Component
{
    /**
     * Success type alert
     */
    const ALERT_SUCCESS = 'success';

    /**
     * Info type alert
     */
    const ALERT_INFO = 'info';

    /**
     * Warning type alert
     */
    const ALERT_WARNING = 'warning';

    /**
     * Danger type alert
     */
    const ALERT_DANGER = 'danger';

    /** Return a formated alert to display from Bootstrap
     * @param String $type
     * @param String $message
     * @return null|string
     */
    public function getAlertComponent(String $type, String $message = '')
    {
        if (!isset($type)) {
            return null;
        }

        $component = '<div class="alert alert-' . $type . ' alert-dismissible" role="alert">';
        $component .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $component .= '<span aria-hidden="true">&times;</span>';
        $component .= '</button>';
        $component .= $message;
        $component .= '</div>';

        return $component;
    }
}
