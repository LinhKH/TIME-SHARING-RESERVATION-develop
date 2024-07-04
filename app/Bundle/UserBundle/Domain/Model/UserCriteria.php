<?php
namespace Devture\Bundle\UserBundle\Model;

use Devture\Bundle\OrganizationBundle\Model\Organization;

class UserCriteria {

	const SORT_TYPE_CREATION_TIME_ASCENDING = 'creation_time_asc';
	const SORT_TYPE_CREATION_TIME_DESCENDING = 'creation_time_desc';

	const ACTIVE_STATUS_YES = 'yes';
	const ACTIVE_STATUS_NO = 'no';
	const ACTIVE_STATUS_ANY = 'any';

	/**
	 * @var Organization|NULL
	 */
	private $organization;

	private $params = array();
	private $errors = array();

	private $csvExport = false;
	private $showFilter = false;

	public function setOrganization(Organization $organization = null) {
		$this->organization = $organization;
	}

	public function getOrganization() {
		return $this->organization;
	}

	public function setEmailKeywords($value) {
		$this->set('emailq', $value);
	}

	public function getEmailKeywords() {
		return $this->get('emailq', null);
	}

	public function setNameKeywords($value) {
		$this->set('nameq', $value);
	}

	public function getNameKeywords() {
		return $this->get('nameq', null);
	}

	public function setType($value) {
		$this->set('type', $value);
	}

	public function getType() {
		return $this->get('type', null);
	}

	public function setPage($value) {
		$this->set('page', $value);
	}

	public function getPage() {
		return $this->get('page', null);
	}

	public function setResultsPerPage($value) {
		$this->set('resultsPerPage', $value);
	}

	public function getResultsPerPage() {
		return $this->get('resultsPerPage', null);
	}

	public function setSortType($value) {
		$this->set('sortType', $value);
	}

	public function getSortType() {
		return $this->get('sortType', null);
	}

	public function getOrganizationKeyWord() {
		return $this->get('organizationKeyword', null);
	}

	public function setOrganizationKeyWord($value) {
		return $this->set('organizationKeyword', $value);
	}

	public function getStartDayFormatted() {
		return $this->get('startDayFormatted', null);
	}

	public function getEndDayFormatted() {
		return $this->get('endDayFormatted', null);
	}

	public function setStartDayFormatted($value) {
		$this->set('startDayFormatted', $value);
	}

	public function setEndDayFormatted($value) {
		$this->set('endDayFormatted', $value);
	}

	public function getActiveStatus() {
		return $this->get('activeStatus', null);
	}

	public function setActiveStatus($value) {
		$this->set('activeStatus', $value);
	}

	public function getError($key) {
		return isset($this->errors[$key]) ? $this->errors[$key] : null;
	}

	public function hasCsvExport() {
		return $this->csvExport;
	}

	public function setCsvExport($value) {
		$this->csvExport = $value;
	}

	public function hasShowFilter() {
		return $this->showFilter;
	}

	public function setShowFilter($value) {
		$this->showFilter = $value;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function setError($key, $message) {
		$this->errors[$key] = $message;
	}

	public function getSubscribeMailMagazine() {
		return $this->get('subscribe_mail_magazine', null);
	}

	public function setSubscribeMailMagazine($value) {
		$this->set('subscribe_mail_magazine', $value);
	}

	/**
	 * Tells whether this filter request is in a good state to be used.
	 */
	public function isValid() {
		return (count($this->getErrors()) === 0);
	}

	private function set($key, $value) {
		$this->params[$key] = $value;
	}

	private function get($key, $defaultValue) {
		return isset($this->params[$key]) ? $this->params[$key] : $defaultValue;
	}

	private function addUniqueElement($fieldKey, $elementValue) {
		$currentValues = $this->get($fieldKey, array());
		if (!in_array($elementValue, $currentValues)) {
			$currentValues[] = $elementValue;
			$this->set($fieldKey, $currentValues);
		}
	}

	static public function getKnownSortTypes() {
		$r = new \ReflectionClass(__CLASS__);
		$results = array();
		foreach ($r->getConstants() as $name => $value) {
			if (strpos($name, 'SORT_TYPE_') !== 0) {
				continue;
			}
			$results[] = $value;
		}
		return $results;
	}

	static public function getKnownActiveStatus() {
		$r = new \ReflectionClass(__CLASS__);
		$results = array();
		foreach ($r->getConstants() as $name => $value) {
			if (strpos($name, 'ACTIVE_STATUS_') !== 0) {
				continue;
			}
			$results[] = $value;
		}
		return $results;
	}

}
