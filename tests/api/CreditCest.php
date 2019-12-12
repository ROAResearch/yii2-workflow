<?php

use app\fixtures\{CreditFixture, OauthAccessTokensFixture};
use Codeception\{Example, Util\HttpCode};
use roaresearch\yii2\roa\test\AbstractResourceCest;

/**
 * Cest to stage resource.
 *
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class CreditCest extends AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    /**
     * @depends TransitionPermissionCest:fixtures
     */
    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'credit' => [
                'class' => CreditFixture::class,
                'depends' => []
            ],
        ]);
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider indexDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function index(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve list of Credit records.');
        $this->internalIndex($I, $example);
    }

    /**
     * @return array<string,array> for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'url' => '/v1/credit',
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 7,
                ],
            ],
            'not found credit' => [
                'url' => '/v1/credit/15',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'filter by author' => [
                'urlParams' => [
                    'created_by' => 1,
                ],
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 7,
                ],
            ],
            'rule created_by' => [
                'urlParams' => [
                    'created_by' => 'wo',
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider viewDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function view(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve Credit single record.');
        $this->internalView($I, $example);
    }

    /**
     * @return array<string,array<string,string>> data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'single record' => [
                'urlParams' => [
                    'id' => 4,
                    'expand' => 'workLogs, activeWorkLog',
                ],
                'httpCode' => HttpCode::OK,
            ],
            'not found credit record' => [
                'url' => '/v1/credit/8',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider createDataProvider
     * @depends CreditWorklogCest:fixtures
     * @before authToken
     */
    public function create(ApiTester $I, Example $example)
    {
        $I->wantTo('Create a Credit record.');
        $this->internalCreate($I, $example);
        if (HttpCode::CREATED == $example['httpCode']) {
            $worklogRoute = $I->grabDataFromResponseByJsonPath(
                '$._links.worklog.href'
            )[0];
            $I->sendGET($worklogRoute);
            $I->seeHTTPHeader('X-PAGINATION-TOTAL-COUNT', 1);
        }
    }

    /**
     * @return array<string,array> data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create credit 1' => [
                'data' => [
                    'workflow_id' => 2,
                    'stage_id' => 4,
                ],
                'httpCode' => HttpCode::CREATED,
            ],
            'dont exists' => [
                'data' => [
                    'workflow_id' => 123,
                    'stage_id' => 2,
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'workflow_id' => 'Workflow ID is invalid.',
                    'stage_id' => 'Not an initial stage for the workflow.'
                ],
            ],
            'not blank' => [
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'workflow_id' => 'Workflow ID cannot be blank.'
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider updateDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function update(ApiTester $I, Example $example)
    {
        $I->wantTo('Update a Credit record.');
        $this->internalUpdate($I, $example);
    }

    /**
     * @return array<string,array> data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'update credit 1' => [
                'url' => '/v1/credit/1',
                'data' => ['workflow_id' => 2],
                'httpCode' => HttpCode::OK,
            ],
            'update credit 10' => [
                'url' => '/v1/credit/10',
                'data' => ['workflow_id' => 2],
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'not exists' => [
                'url' => '/v1/credit/1',
                'data' => ['workflow_id' => 123],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'workflow_id' => 'Workflow ID is invalid.',
                ],
            ],
            'not blank' => [
                'url' => '/v1/credit/1',
                'data' => ['workflow_id' => ''],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'workflow_id' => 'Workflow ID cannot be blank.'
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider deleteDataProvider
     * @depends CreditWorklogCest:create
     * @before authToken
     */
    public function delete(ApiTester $I, Example $example)
    {
        $I->wantTo('Delete a Credit record.');
        $this->internalDelete($I, $example);
    }

    /**
     * @return array[] data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'credit not found' => [
                'url' => '/v1/credit/10',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'delete credit 5' => [
                'url' => '/v1/credit/5',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'not found' => [
                'url' => '/v1/credit/5',
                'httpCode' => HttpCode::NOT_FOUND,
                'validationErrors' => [
                    'name' => 'The record "5" does not exists.'
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    protected function recordJsonType()
    {
        return [
            'id' => 'integer:>0',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getRoutePattern()
    {
        return 'v1/credit';
    }
}
