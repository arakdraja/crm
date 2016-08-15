<?php

namespace OroCRM\Bundle\AnalyticsBundle\EventListener;

use Oro\Bundle\ConfigBundle\Event\ConfigUpdateEvent;
use OroCRM\Bundle\AnalyticsBundle\Model\RFMMetricStateManager;
use OroCRM\Bundle\AnalyticsBundle\Service\ScheduleCalculateAnalyticsService;

class TimezoneChangeListener
{
    /** @var RFMMetricStateManager */
    protected $metricStateManager;

    /**
     * @var ScheduleCalculateAnalyticsService
     */
    protected $scheduleCalculateAnalyticsService;

    /**
     * @param RFMMetricStateManager $metricStateManager
     * @param ScheduleCalculateAnalyticsService $scheduleCalculateAnalyticsService
     */
    public function __construct(
        RFMMetricStateManager $metricStateManager,
        ScheduleCalculateAnalyticsService $scheduleCalculateAnalyticsService
    ) {
        $this->metricStateManager = $metricStateManager;
        $this->scheduleCalculateAnalyticsService = $scheduleCalculateAnalyticsService;
    }

    /**
     * @param ConfigUpdateEvent $event
     */
    public function onConfigUpdate(ConfigUpdateEvent $event)
    {
        if (!$event->isChanged('oro_locale.timezone')) {
            return;
        }
        $this->metricStateManager->resetMetrics();
        $this->scheduleCalculateAnalyticsService->scheduleForAllChannels();
    }
}
