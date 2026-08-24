<?php declare(strict_types=1);

namespace Bhp\Api\Api\X\ActivityComponents;

use Bhp\Api\Support\AbstractApiClient;
use Bhp\Request\Request;
use Bhp\WbiSign\WbiSign;

final class ApiMission extends AbstractApiClient
{
    private const WEB_LOCATION = '888.126558';

    /**
     * 初始化 ApiMission
     * @param Request $request
     */
    public function __construct(
        Request $request,
    ) {
        parent::__construct($request);
    }

    /**
     * @return array<string, mixed>
     */
    public function info(string $taskId): array
    {
        return $this->decodeGet(
            'pc',
            'https://api.bilibili.com/x/activity_components/mission/info',
            WbiSign::encryption([
                'task_id' => $taskId,
                'web_location' => self::WEB_LOCATION,
            ]),
            [
                'origin' => 'https://www.bilibili.com',
                'referer' => "https://www.bilibili.com/blackboard/era/award-exchange.html?task_id={$taskId}",
            ],
            'activity_components.mission.info',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function receive(
        string $taskId,
        string $activityId,
        string $activityName,
        string $taskName,
        string $rewardName,
        string $gaiaVToken = '',
    ): array {
        return $this->decodePostWithQuery(
            'pc',
            'https://api.bilibili.com/x/activity_components/mission/receive',
            [
                'task_id' => $taskId,
                'activity_id' => $activityId,
                'activity_name' => $activityName,
                'task_name' => $taskName,
                'reward_name' => $rewardName,
                'gaia_vtoken' => $gaiaVToken,
                'receive_from' => 'missionPage',
                'csrf' => $this->request()->csrfValue(),
            ],
            WbiSign::encryption([
                'web_location' => self::WEB_LOCATION,
            ]),
            [
                'origin' => 'https://www.bilibili.com',
                'referer' => "https://www.bilibili.com/blackboard/era/award-exchange.html?task_id={$taskId}",
            ],
            'activity_components.mission.receive',
        );
    }
}
