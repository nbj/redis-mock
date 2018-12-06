<?php

namespace Nbj\Mocks;

use Closure;

/**
 * @method int del(array $keys)
 * @method string dump($key)
 * @method int expire($key, $seconds)
 * @method int expireat($key, $timestamp)
 * @method array keys($pattern)
 * @method int move($key, $db)
 * @method mixed object($subcommand, $key)
 * @method int persist($key)
 * @method int pexpire($key, $milliseconds)
 * @method int pexpireat($key, $timestamp)
 * @method int pttl($key)
 * @method string randomkey()
 * @method mixed rename($key, $target)
 * @method int renamenx($key, $target)
 * @method array scan($cursor, array $options = null)
 * @method array sort($key, array $options = null)
 * @method int ttl($key)
 * @method mixed type($key)
 * @method int append($key, $value)
 * @method int bitcount($key, $start = null, $end = null)
 * @method int bitop($operation, $destkey, $key)
 * @method array bitfield($key, $subcommand, ...$subcommandArg)
 * @method int decr($key)
 * @method int decrby($key, $decrement)
 * @method int getbit($key, $offset)
 * @method string getrange($key, $start, $end)
 * @method string getset($key, $value)
 * @method int incr($key)
 * @method int incrby($key, $increment)
 * @method string incrbyfloat($key, $increment)
 * @method array mget(array $keys)
 * @method mixed mset(array $dictionary)
 * @method int msetnx(array $dictionary)
 * @method mixed psetex($key, $milliseconds, $value)
 * @method int setbit($key, $offset, $value)
 * @method int setex($key, $seconds, $value)
 * @method int setnx($key, $value)
 * @method int setrange($key, $offset, $value)
 * @method int strlen($key)
 * @method int hdel($key, array $fields)
 * @method array hgetall($key)
 * @method int hincrby($key, $field, $increment)
 * @method string hincrbyfloat($key, $field, $increment)
 * @method array hkeys($key)
 * @method int hlen($key)
 * @method array hmget($key, array $fields)
 * @method mixed hmset($key, array $dictionary)
 * @method array hscan($key, $cursor, array $options = null)
 * @method array hvals($key)
 * @method int hstrlen($key, $field)
 * @method array blpop(array $keys, $timeout)
 * @method array brpop(array $keys, $timeout)
 * @method array brpoplpush($source, $destination, $timeout)
 * @method string lindex($key, $index)
 * @method int linsert($key, $whence, $pivot, $value)
 * @method string lpop($key)
 * @method int lpush($key, array $values)
 * @method int lpushx($key, $value)
 * @method int lrem($key, $count, $value)
 * @method mixed lset($key, $index, $value)
 * @method string rpop($key)
 * @method string rpoplpush($source, $destination)
 * @method int rpushx($key, $value)
 * @method int scard($key)
 * @method array sdiff(array $keys)
 * @method int sdiffstore($destination, array $keys)
 * @method array sinter(array $keys)
 * @method int sinterstore($destination, array $keys)
 * @method int sismember($key, $member)
 * @method int smove($source, $destination, $member)
 * @method string spop($key, $count = null)
 * @method string srandmember($key, $count = null)
 * @method int srem($key, $member)
 * @method array sscan($key, $cursor, array $options = null)
 * @method array sunion(array $keys)
 * @method int sunionstore($destination, array $keys)
 * @method int zadd($key, array $membersAndScoresDictionary)
 * @method int zcard($key)
 * @method string zcount($key, $min, $max)
 * @method int zinterstore($destination, array $keys, array $options = null)
 * @method array zrange($key, $start, $stop, array $options = null)
 * @method array zrangebyscore($key, $min, $max, array $options = null)
 * @method int zrank($key, $member)
 * @method int zremrangebyrank($key, $start, $stop)
 * @method int zremrangebyscore($key, $min, $max)
 * @method array zrevrange($key, $start, $stop, array $options = null)
 * @method array zrevrangebyscore($key, $max, $min, array $options = null)
 * @method int zrevrank($key, $member)
 * @method int zunionstore($destination, array $keys, array $options = null)
 * @method array zscan($key, $cursor, array $options = null)
 * @method array zrangebylex($key, $start, $stop, array $options = null)
 * @method array zrevrangebylex($key, $start, $stop, array $options = null)
 * @method int zremrangebylex($key, $min, $max)
 * @method int zlexcount($key, $min, $max)
 * @method int pfadd($key, array $elements)
 * @method mixed pfmerge($destinationKey, array $sourceKeys)
 * @method int pfcount(array $keys)
 * @method mixed pubsub($subcommand, $argument)
 * @method int publish($channel, $message)
 * @method mixed discard() // DO NOT IMPLEMENT THIS AS TESTS REQUIRE IT NOT TO BE!!!!!!111!!!11one!!
 * @method array exec()
 * @method mixed multi()
 * @method mixed unwatch()
 * @method mixed watch($key)
 * @method mixed eval($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed evalsha($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed script($subcommand, $argument = null)
 * @method mixed auth($password)
 * @method string echo ($message)
 * @method mixed ping($message = null)
 * @method mixed select($database)
 * @method mixed bgrewriteaof()
 * @method mixed bgsave()
 * @method mixed config($subcommand, $argument = null)
 * @method int dbsize()
 * @method mixed flushdb()
 * @method array info($section = null)
 * @method int lastsave()
 * @method mixed save()
 * @method mixed slaveof($host, $port)
 * @method mixed slowlog($subcommand, $argument = null)
 * @method int geoadd($key, $longitude, $latitude, $member)
 * @method array geohash($key, array $members)
 * @method array geopos($key, array $members)
 * @method string geodist($key, $member1, $member2, $unit = null)
 * @method array georadius($key, $longitude, $latitude, $radius, $unit, array $options = null)
 * @method array georadiusbymember($key, $member, $radius, $unit, array $options = null)
 */
class Redis
{
    /**
     * Holds the value Redis will return when called next
     *
     * @var mixed $returnValue
     */
    protected static $returnValue = null;

    /**
     * Holds the cache for all stored sets
     *
     * @var array $storedSetCache
     */
    protected $storedSetCache = [];

    /**
     * Holds the cache for all lists
     *
     * @var array $listCache
     */
    protected $listCache = [];

    /**
     * Holds the cache for all hashes
     *
     * @var array $hashCache
     */
    protected $hashCache = [];

    /**
     * Holds the cache for all sets
     *
     * @var array $storedSetCache
     */
    protected $setCache = [];

    /**
     * Holds the cache for all strings
     *
     * @var array $stringCache
     */
    protected $stringCache = [];

    /**
     * Holds the result of a pipeline
     *
     * @var array
     */
    protected $pipelineResultCache = [];

    /**
     * Boolean that tells if operations should run in a pipeline
     *
     * @var bool
     */
    protected $isPipeline = false;

    /**
     * Set the value Redis should return when called next
     *
     * @param mixed $returnValue
     */
    public static function shouldReturn($returnValue)
    {
        self::$returnValue = $returnValue;
    }

    /**
     * Array implementation of Redis::zincrby()
     *
     * @param string $key
     * @param int $increment
     * @param string $member
     *
     * @return int
     */
    public function zincrby($key, $increment, $member)
    {
        if (!isset($this->storedSetCache[$key][$member])) {
            $this->storedSetCache[$key][$member] = 0;
        }

        $this->storedSetCache[$key][$member] += $increment;

        if ($this->isPipeline) {
            $this->pipelineResultCache[] = $this->storedSetCache[$key][$member];
        }

        return $this->storedSetCache[$key][$member];
    }

    /**
     * Array implementation of Redis::zscore()
     *
     * @param string $key
     * @param string $member
     *
     * @return int
     */
    public function zscore($key, $member)
    {
        if (!is_null(self::$returnValue)) {
            $value = self::$returnValue;
            self::$returnValue = null;

            return $value;
        }

        if (!isset($this->storedSetCache[$key][$member])) {
            return null;
        }

        return $this->storedSetCache[$key][$member];
    }

    /**
     * Removes one or more member from a sorted set returning the number of removed members
     *
     * @param string $key
     * @param string|array $member
     *
     * @return int
     */
    public function zrem($key, $member)
    {
        if (is_array($member)) {
            $this->pipeline(function ($redis) use ($key, $member) {
                foreach ($member as $item) {
                    $redis->zrem($key, $item);
                }
            });

            return count($member);
        }

        unset($this->storedSetCache[$key][$member]);

        return 1;
    }

    /**
     * Appends a values to a list
     *
     * @param string $key
     * @param mixed $value
     *
     * @return int Number of elements in the list
     */
    public function rpush($key, $value)
    {
        if (!isset($this->listCache[$key])) {
            $this->listCache[$key] = [];
        }

        array_push($this->listCache[$key], $value);

        return count($this->listCache[$key]);
    }

    /**
     * Gets a subset of elements from a list
     *
     * @param string $key
     * @param int $start
     * @param int $stop
     *
     * @return mixed
     */
    public function lrange($key, $start, $stop)
    {
        if (!is_null(self::$returnValue)) {
            $value = self::$returnValue;
            self::$returnValue = null;

            return $value;
        }

        if (!isset($this->listCache[$key])) {
            return [];
        }

        if ($start > count($this->listCache[$key])) {
            return [];
        }

        $startIndex = $start >= 0
            ? $start
            : count($this->listCache[$key]) + $start;

        $stopIndex = $stop >= 0
            ? $stop
            : count($this->listCache[$key]) + $stop;

        if ($startIndex > $stopIndex) {
            return [];
        }

        return collect($this->listCache[$key])
            ->slice($startIndex, $stopIndex - $startIndex + 1)
            ->toArray();
    }

    /**
     * Gets the length of the list stored at key
     *
     * @param string $key
     *
     * @return int
     */
    public function llen($key)
    {
        return count($this->listCache[$key]);
    }

    /**
     * Trims an existing list so that it will contain only the specified range
     *
     * @param string $key
     * @param int $start
     * @param int $stop
     *
     * @return string
     */
    public function ltrim($key, $start, $stop)
    {
        if ($start > count($this->listCache[$key])) {
            $this->listCache[$key] = [];
        }

        $startIndex = $start >= 0
            ? $start
            : count($this->listCache[$key]) + $start;

        $stopIndex = $stop >= 0
            ? $stop
            : count($this->listCache[$key]) + $stop;

        if ($startIndex > $stopIndex) {
            $this->listCache[$key] = [];
        }

        $this->listCache[$key] = collect($this->listCache[$key])
            ->slice($startIndex, $stopIndex - $startIndex + 1)
            ->toArray();

        return 'OK';
    }

    /**
     * Checks if a key and field exists for a hash
     *
     * @param string $key
     * @param string $field
     *
     * @return bool
     */
    public function hexists($key, $field)
    {
        return isset($this->hashCache[$key][$field]);
    }

    /**
     * Sets the value for a key and field in a hash
     *
     * @param string $key
     * @param string $field
     * @param string $value
     *
     * @return int
     */
    public function hset($key, $field, $value)
    {
        $returnValue = 1;

        if ($this->hexists($key, $field)) {
            $returnValue = 0;
        }

        $this->hashCache[$key][$field] = $value;

        return $returnValue;
    }

    /**
     * Sets field in the hash stored at key to value, only if field does not yet exist.
     *
     * @param string $key
     * @param string $field
     * @param string $value
     *
     * @return int
     */
    public function hsetnx($key, $field, $value)
    {
        if ($this->hexists($key, $field)) {
            return 0;
        }

        $this->hashCache[$key][$field] = $value;

        return 1;
    }

    /**
     * Gets the value for a key and field in a hash
     *
     * @param string $key
     * @param string $field
     *
     * @return null
     */
    public function hget($key, $field)
    {
        if (!$this->hexists($key, $field)) {
            return null;
        }

        return $this->hashCache[$key][$field];
    }

    /**
     * Appends a value to a set
     *
     * @param string $key
     * @param string $value
     *
     * @return int
     */
    public function sadd($key, $value)
    {
        if (!isset($this->setCache[$key])) {
            $this->setCache[$key] = [];
        }

        if (in_array($value, $this->setCache[$key])) {
            return 0;
        }

        array_push($this->setCache[$key], $value);

        return 1;
    }

    /**
     * Returns all members/values of a specific set
     *
     * @param string $key
     *
     * @return array
     */
    public function smembers($key)
    {
        if (!isset($this->setCache[$key])) {
            return [];
        }

        return $this->setCache[$key];
    }

    /**
     * Gets the value stored at the key specified
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!isset($this->stringCache[$key])) {
            return null;
        }

        return $this->stringCache[$key];
    }

    /**
     * Sets the value at a specific key
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    public function set($key, $value)
    {
        $this->stringCache[$key] = $value;

        return 'OK';
    }

    /**
     * Checks if a key is set
     *
     * @param string $key
     *
     * @return int
     */
    public function exists($key)
    {
        return (int) isset($this->stringCache[$key]);
    }

    /**
     * Returns 1970-01-01 00:00:00 in unix time (Seconds since this date)
     *
     * @return int
     */
    public function time()
    {
        return 0;
    }

    /**
     * Bundle redis operation into a pipeline
     *
     * @param Closure $closure
     *
     * @return array
     */
    public function pipeline(Closure $closure)
    {
        $this->isPipeline = true;

        $closure($this);

        $pipelineResult = $this->pipelineResultCache;
        $this->pipelineResultCache = [];

        $this->isPipeline = false;

        return $pipelineResult;
    }

    /**
     * Flushes all keys from the Redis mock
     */
    public function flushAll()
    {
        $this->listCache = [];
        $this->hashCache = [];
        $this->storedSetCache = [];
        $this->stringCache = [];
        $this->pipelineResultCache = [];
        $this->setCache = [];
    }

    /**
     * Swallows all calls to Redis
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (!is_null(self::$returnValue)) {
            $value = self::$returnValue;
            self::$returnValue = null;

            return $value;
        }

        return null;
    }
}
