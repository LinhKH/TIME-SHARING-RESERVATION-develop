<?php
namespace Devture\Bundle\UserBundle\Helper;

use Symfony\Component\HttpFoundation\Request;
use Devture\Component\DBAL\Exception\NotFound;
use Devture\Bundle\UserBundle\Model\FilterRequest;
use Devture\Bundle\OrganizationBundle\Model\Organization;
use Devture\Bundle\OrganizationBundle\Repository\OrganizationRepository;

class FilterRequestBuilder {

	private $organizationRepository;

	public function __construct(OrganizationRepository $organizationRepository) {
		$this->organizationRepository = $organizationRepository;
	}

	private function addOrganizationFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$organizationId = $httpRequest->query->get('organizationId', null);
		try {
			$organization = $this->organizationRepository->find($organizationId);
			$filterRequest->setOrganization($organization);
		} catch (NotFound $e) {

		}
	}

	private function addTypeFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$type = $httpRequest->query->get('type', null);

		if ($type && $type !== 'all') {
			$filterRequest->setType($type);
		}
	}

	private function addActiveStatusFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$filterRequest->setActiveStatus(FilterRequest::ACTIVE_STATUS_ANY);
		$status = $httpRequest->query->get('activeStatus', null);

		if ($status != null) {
			$filterRequest->setActiveStatus($status);
		}
	}

	private function addSortTypeFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$sortType = $httpRequest->query->get('sortType', null);
		$filterRequest->setSortType(FilterRequest::SORT_TYPE_CREATION_TIME_DESCENDING);

		if (in_array($sortType, FilterRequest::getKnownSortTypes())) {
			$filterRequest->setSortType($sortType);
		}
	}

	private function addEmailKeywordsFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$keywords = $httpRequest->query->get('emailq', null);
		if ($keywords) {
			$filterRequest->setEmailKeywords($keywords);
		}
	}

	private function addNameKeywordsFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$keywords = $httpRequest->query->get('nameq', null);
		if ($keywords) {
			$filterRequest->setNameKeywords($keywords);
		}
	}

	private function addOrganizationKeywordFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$keyword = $httpRequest->query->get('organizationKeyword', null);
		if ($keyword != null) {
			$filterRequest->setOrganizationKeyword(
				\voku\helper\UTF8::cleanup($keyword)
			);
		}
	}

	private function addSubscribeMailMagazineFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$value = $httpRequest->query->get('subscribeMailMagazine', null);
		if ($value !== null) {
			$filterRequest->setSubscribeMailMagazine($value);
		}
	}

	private function addPaginationFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$filterRequest->setPage(0);

		$page = $httpRequest->query->get('page', null);
		if ($page !== null) {
			$page = (int) $page;
			if ($page > 0) {
				$filterRequest->setPage($page);
			}
		}
	}

	private function addDurationFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$filterRequest->setStartDayFormatted(null);
		$filterRequest->setEndDayFormatted(null);

		$startDay = $httpRequest->query->get('startDayFormatted', null);
		if (!empty($startDay)) {
			$filterRequest->setStartDayFormatted($startDay);
		}
		$endDay = $httpRequest->query->get('endDayFormatted', null);
		if (!empty($endDay)) {
			$filterRequest->setEndDayFormatted($endDay);
		}
	}

	private function addCsvExportFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$filterRequest->setCsvExport(false);
		if ($httpRequest->query->has('csv_export')) {
			$filterRequest->setCsvExport(true);
		}
	}

	private function addShowFilter(FilterRequest $filterRequest, Request $httpRequest) {
		$filterRequest->setShowFilter(false);
		if ($httpRequest->query->has('filter')) {
			$filterRequest->setShowFilter(true);
		}
	}

	public function buildFromHttpRequest(Request $httpRequest) {
		$filterRequest = new FilterRequest();

		$this->addTypeFilter($filterRequest, $httpRequest);
		$this->addActiveStatusFilter($filterRequest, $httpRequest);
		$this->addSortTypeFilter($filterRequest, $httpRequest);
		$this->addOrganizationFilter($filterRequest, $httpRequest);
		$this->addEmailKeywordsFilter($filterRequest, $httpRequest);
		$this->addNameKeywordsFilter($filterRequest, $httpRequest);
		$this->addOrganizationKeywordFilter($filterRequest, $httpRequest);
		$this->addSubscribeMailMagazineFilter($filterRequest, $httpRequest);
		$this->addDurationFilter($filterRequest, $httpRequest);
		$this->addCsvExportFilter($filterRequest, $httpRequest);
		$this->addShowFilter($filterRequest, $httpRequest);
		$this->addPaginationFilter($filterRequest, $httpRequest);

		return $filterRequest;
	}

	/**
	 * Exports the filter request as an array of parameters,
	 * useful for making links or other HTTP requests that can later
	 * be restored to give you the same request.
	 *
	 * @param FilterRequest $filterRequest
	 */
	public function exportParams(FilterRequest $filterRequest) {
		$params = array();

		if ($filterRequest->getPage()) {
			$params['page'] = $filterRequest->getPage();
		}

		$params['sortType'] = $filterRequest->getSortType();

		if ($filterRequest->getNameKeywords()) {
			$params['nameq'] = $filterRequest->getNameKeywords();
		}

		if ($filterRequest->getEmailKeywords()) {
			$params['emailq'] = $filterRequest->getEmailKeywords();
		}

		if ($filterRequest->getOrganizationKeyword()) {
			$params['organizationKeyword'] = $filterRequest->getOrganizationKeyword();
		}

		if ($filterRequest->getType()) {
			$params['type'] = $filterRequest->getType();
		}

		if ($filterRequest->getActiveStatus()) {
			$params['activeStatus'] = $filterRequest->getActiveStatus();
		}

		if ($filterRequest->getStartDayFormatted()) {
			$params['startDayFormatted'] = $filterRequest->getStartDayFormatted();
		}

		if ($filterRequest->getEndDayFormatted()) {
			$params['endDayFormatted'] = $filterRequest->getEndDayFormatted();
		}

		if ($filterRequest->getSubscribeMailMagazine()) {
			$params['subscribeMailMagazine'] = $filterRequest->getSubscribeMailMagazine();
		}

		if ($filterRequest->hasShowFilter()) {
			$params['filter'] = '';
		}

		if ($filterRequest->getOrganization() instanceof Organization) {
			$params['organizationId'] = $filterRequest->getOrganization()->getId();
		}

		return $params;
	}

}
