<?php
App::uses('HttpSocket', 'Network/Http');

class ZusaarSource extends DataSource {

/**
 * [$params description]
 * @link http://www.zusaar.com/doc/api.html
 * @var array
 */
    public $params = array(
        'event_id',
        'keyword',
        'keyword_or',
        'ym',
        'ymd',
        'user_id',
        'nickname',
        'twitter_id',
        'owner_id',
        'owner_nickname',
        'owner_twitter_id',
        'start',
        'count',
        'format',
    );
/**
 * [$user_params description]
 * @link http://www.zusaar.com/doc/api.html
 * @var array
 */
    public $user_params = array(
        'event_id',
        'user_id',
        'nickname',
        'twitter_id',
        'owner_id',
        'owner_nickname',
        'start',
        'count',
        'format',
    );



/**
 * An optional description of your datasource
 */
    public $description = 'A far away datasource';

/**
 * Our default config options. These options will be customized in our
 * ``app/Config/database.php`` and will be merged in the ``__construct()``.
 */
    public $config = array(
        'apiKey' => '',
    );

/**
 * If we want to create() or update() we need to specify the fields
 * available. We use the same array keys as we do with CakeSchema, eg.
 * fixtures and schema migrations.
 */
    protected $_schema = array(
        'id' => array(
            'type' => 'integer',
            'null' => false,
            'key' => 'primary',
            'length' => 11,
        ),
        'name' => array(
            'type' => 'string',
            'null' => true,
            'length' => 255,
        ),
        'message' => array(
            'type' => 'text',
            'null' => true,
        ),
    );

/**
 * Create our HttpSocket and handle any config tweaks.
 */
    public function __construct($config) {
        parent::__construct($config);
        $this->Http = new HttpSocket();
    }

/**
 * Since datasources normally connect to a database there are a few things
 * we must change to get them to work without a database.
 */

/**
 * listSources() is for caching. You'll likely want to implement caching in
 * your own way with a custom datasource. So just ``return null``.
 */
    public function listSources() {
        return null;
    }

/**
 * describe() tells the model your schema for ``Model::save()``.
 *
 * You may want a different schema for each model but still use a single
 * datasource. If this is your case then set a ``schema`` property on your
 * models and simply return ``$Model->schema`` here instead.
 */
    public function describe(Model $Model) {
        return $this->_schema;
    }

/**
 * calculate() is for determining how we will count the records and is
 * required to get ``update()`` and ``delete()`` to work.
 *
 * We don't count the records here but return a string to be passed to
 * ``read()`` which will do the actual counting. The easiest way is to just
 * return the string 'COUNT' and check for it in ``read()`` where
 * ``$data['fields'] == 'COUNT'``.
 */
    public function calculate(Model $Model, $func, $params = array()) {
        return 'COUNT';
    }

/**
 * Implement the R in CRUD. Calls to ``Model::find()`` arrive here.
 */
    public function read(Model $Model, $data = array()) {
        /**
         * Here we do the actual count as instructed by our calculate()
         * method above. We could either check the remote source or some
         * other way to get the record count. Here we'll simply return 1 so
         * ``update()`` and ``delete()`` will assume the record exists.
         */
        if ($data['fields'] == 'COUNT') {
            return array(array(array('count' => 1)));
        }
        /**
         * Now we get, decode and return the remote data.
         */
        // $data['conditions']['apiKey'] = $this->config['apiKey'];
        $response = $this->Http->get('http://api.atnd.org/events/', $data['conditions']);
        return array($Model->alias => $response);
    }

/**
 * Implement the C in CRUD. Calls to ``Model::save()`` without $Model->id
 * set arrive here.
 */
    public function create(Model $Model, $fields = array(), $values = array()) {
        $data = array_combine($fields, $values);
        $data['apiKey'] = $this->config['apiKey'];
        $json = $this->Http->post('http://example.com/api/set.json', $data);
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return true;
    }

/**
 * Implement the U in CRUD. Calls to ``Model::save()`` with $Model->id
 * set arrive here. Depending on the remote source you can just call
 * ``$this->create()``.
 */
    public function update(Model $Model, $fields = array(), $values = array()) {
        return $this->create($Model, $fields, $values);
    }

/**
 * Implement the D in CRUD. Calls to ``Model::delete()`` arrive here.
 */
    public function delete(Model $Model, $conditions = null) {
        $id = $conditions[$Model->alias . '.id'];
        $json = $this->Http->get('http://example.com/api/remove.json', array(
            'id' => $id,
            'apiKey' => $this->config['apiKey'],
        ));
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return true;
    }

}
