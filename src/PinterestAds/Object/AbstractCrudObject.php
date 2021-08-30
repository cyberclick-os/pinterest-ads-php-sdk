<?php

namespace PinterestAds\Object;
use Exception;
use InvalidArgumentException;
use PinterestAds\Api;
use PinterestAds\Cursor;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Http\ResponseInterface;

class AbstractCrudObject extends AbstractObject {

  const FIELD_ID = 'id';

  protected static array $defaultReadFields = array();

  protected array $changedFields = array();

  protected Api $api;

  protected ?string $parentId;

  /**
   * @deprecated deprecate constructor with null and parent_id
   * @param string $id Optional (do not set for new objects)
   * @param string $parent_id Optional, needed for creating new objects.
   * @param Api $api The Api instance this object should use to make calls
   */
  public function __construct(string $id = null, string $parent_id = null, Api $api = null) {
    parent::__construct();

    // check that $id is an integer or a string integer or a string of
    // two integer connected by an underscore, like "123_456"

    $int_id = $id;
    if (strpos($id, 'act_') === 0) {
      $int_id = substr($id, 4);
    }
    $split_by_underscore = explode('_', (string) $id);
    $is_regular_id = sizeof($split_by_underscore) == 2 &&
                     ctype_digit($split_by_underscore[0]) &&
                     ctype_digit($split_by_underscore[1]);
    if (!is_null($int_id) && !ctype_digit((string) $int_id) && !$is_regular_id) {
      $extra_message = '';
      if (is_numeric($int_id)) {
        $extra_message = ' Please use an integer string'
        .' to prevent integer overflow.';
      }
      throw new InvalidArgumentException(
        'Object ID must be an integer or integer string but was passed "'
        .(string)$id.'" ('.gettype($id).').'.(string)$extra_message);
    }
    $this->data[static::FIELD_ID] = $id;

    if (!is_null($parent_id)) {
      $warning_message = "\$parent_id as a parameter of constructor is being " .
        "deprecated, please try not to use this in new code.\n";
      trigger_error($warning_message, E_USER_DEPRECATED);
    }
    $this->parentId = $parent_id;

    $this->api = static::assureApi($api);
  }

  public function setId(string $id) {
    $this->data[static::FIELD_ID] = $id;
    return $this;
  }

  public function setParentId(string $parent_id) {
    $warning_message = sprintf('%s is being deprecated, please try not to use'.
      ' this in new code.',__FUNCTION__);
    trigger_error($warning_message, E_USER_DEPRECATED);
    $this->parentId = $parent_id;
    return $this;
  }

  public function setApi(Api $api) {
    $this->api = static::assureApi($api);
    return $this;
  }

  protected static function assureApi(?Api $instance = null): Api {
    $instance = $instance ?: Api::instance();
    if (!$instance) {
      throw new InvalidArgumentException(
        'An Api instance must be provided as argument or '.
        'set as instance in the \FacebookAds\Api');
    }
    return $instance;
  }

  protected function assureId(): string {
    if (!$this->data[static::FIELD_ID]) {
      throw new Exception("field '".static::FIELD_ID."' is required.");
    }
    return (string) $this->data[static::FIELD_ID];
  }

  public function api(): Api {
    return $this->api;
  }

  public function changedValues():array {
    return $this->changedFields;
  }

  public function changedFields(): array {
    return array_keys($this->changedFields);
  }

  public function exportData(): array {
    $data = array();
    foreach ($this->changedFields as $key => $val) {
      $data[$key] = parent::exportValue($val);
    }
    return $data;
  }

  protected function clearHistory() {
    $this->changedFields = array();
  }

  public function __set(string $name, $value) {
    if (!array_key_exists($name, $this->data)
      || $this->data[$name] !== $value) {
      $this->changedFields[$name] = $value;
    }
    parent::__set($name, $value);
  }

  public static function setDefaultReadFields(array $fields = array()) {
    static::$defaultReadFields = $fields;
  }

  public static function defaultReadFields(): array {
    return static::$defaultReadFields;
  }

  protected function nodePath(): string {
    return '/'.$this->assureId();
  }

  protected function assureEndpoint(string $prototype_class, string $endpoint): string {
    $warning_message = sprintf('%s is being deprecated, please try not to use'.
      ' this in new code.',__FUNCTION__);
    trigger_error($warning_message, E_USER_DEPRECATED);
    if (!$endpoint) {
      $prototype = new $prototype_class(null, null, $this->api());
      if (!$prototype instanceof AbstractCrudObject) {
        throw new InvalidArgumentException('Either prototype must be instance
          of AbstractCrudObject or $endpoint must be given');
      }
      $endpoint = $prototype->endpoint();
    }
    return $endpoint;
  }

  protected function fetchConnection(
    array $fields = array(),
    array $params = array(),
    string $prototype_class = '',
    ?string $endpoint = null): ResponseInterface {
    $fields = implode(',', $fields ?: static::defaultReadFields());
    if ($fields) {
      $params['fields'] = $fields;
    }
    $endpoint = $this->assureEndpoint($prototype_class, $endpoint);
    return $this->api()->call(
      '/'.$this->assureId().'/'.$endpoint,
      RequestInterface::METHOD_GET,
      $params);
  }

  protected function getOneByConnection(
    string $prototype_class,
    array $fields = array(),
    array $params = array(),
    ?string $endpoint = null): ?AbstractObject {
    $response = $this->fetchConnection(
      $fields, $params, $prototype_class, $endpoint);
    if (!$response->content()) {
      return null;
    }
    $object = new $prototype_class(
      null, null, $this->api());
    /** @var AbstractCrudObject $object */
    $object->setDataWithoutValidation($response->content());
    return $object;
  }

  protected function getManyByConnection(
    string $prototype_class,
    array $fields = array(),
    array $params = array(),
    ?string $endpoint = null): Cursor {
    $response = $this->fetchConnection(
      $fields, $params, $prototype_class, $endpoint);
    return new Cursor(
      $response,
      new $prototype_class(null, null, $this->api()));
  }

  protected function createAsyncJob(
    string $job_class,
    array $fields = array(),
    array $params = array()) {
    $object = new $job_class(null, $this->assureId(), $this->api());
    if (!$object instanceof AbstractAsyncJobObject) {
      throw new InvalidArgumentException(
        "Class {$job_class} is not of type "
        .AbstractAsyncJobObject::className());
    }
    $params['fields'] = $fields;
    return $object->create($params);
  }

  public static function deleteIds(array $ids, ?Api $api = null):bool {
    $batch = array();
    foreach ($ids as $id) {
      $request = array(
        'relative_url' => '/'.$id,
        'method' => RequestInterface::METHOD_DELETE,
      );
      $batch[] = $request;
    }
    $api = static::assureApi($api);
    $response = $api->call(
      '/',
      RequestInterface::METHOD_POST,
      array('batch' => json_encode($batch)));
    foreach ($response->content() as $result) {
      if (200 != $result['code']) {
        return false;
      }
    }
    return true;
  }

  public static function readIds(
    array $ids,
    array $fields = array(),
    array $params = array(),
    ?Api $api = null): Cursor {
    if (empty($fields)) {
      $fields = static::defaultReadFields();
    }
    if (!empty($fields)) {
      $params['fields'] = implode(',', $fields);
    }
    $params['ids'] = implode(',', $ids);
    $api = static::assureApi($api);
    $response = $api->call('/', RequestInterface::METHOD_GET, $params);
    $result = array();
    foreach ($response->content() as $data) {
      $object = new static(null, null, $api);
      $object->setDataWithoutValidation((array) $data);
      $result[] = $object;
    }
    return $result;
  }
}
