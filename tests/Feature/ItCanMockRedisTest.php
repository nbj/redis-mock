<?php

namespace Tests\Feature;

use Nbj\Mocks\Redis;
use Tests\RedisMockFacade;
use PHPUnit\Framework\TestCase;

class RedisMockTest extends TestCase
{
    /**
     * @var Redis $redis
     */
    protected $redis;

    /**
     * Runs before each test
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->redis = new Redis;
    }

    /** @test */
    public function it_can_be_accessed_by_the_redis_facade()
    {
        // We use the Redis time() method as it expects no arguments
        $time = $this->redis->time();

        $this->assertEquals(0, $time);
    }

    /** @test */
    public function it_sends_not_implemented_redis_functions_to_underscore_underscore_call()
    {
        // We use the Redis discard() method as we have no implementation for this
        $this->assertEquals(null, $this->redis->discard());

        Redis::shouldReturn('some-nice-value');
        $this->assertEquals('some-nice-value', $this->redis->discard());
    }

    /** @test */
    public function zincrby_increments_a_score_of_a_stored_set()
    {
        $key = 'some-key';
        $member = 'some-member';
        $this->assertEquals(0, $this->redis->zscore($key, $member));

        $this->redis->zincrby($key, 1, $member);
        $this->redis->zincrby($key, 1, $member);
        $this->redis->zincrby($key, 1, $member);
        $this->redis->zincrby($key, 1, $member);
        $this->redis->zincrby($key, 1, $member);

        $this->assertEquals(5, $this->redis->zscore($key, $member));
    }

    /** @test */
    public function zscore_returns_the_score_of_a_stored_set()
    {
        $keyA = 'some-key';
        $memberA = 'some-member';

        $keyB = 'some-other-key';
        $memberB = 'some-other-member';

        for ($increment = 1; $increment <= 10; $increment += 2) {
            $this->redis->zincrby($keyB, $increment, $memberB);
        }

        $this->assertEquals(0, $this->redis->zscore($keyA, $memberA));
        $this->assertEquals(25, $this->redis->zscore($keyB, $memberB));
    }

    /** @test */
    public function zrem_removes_one_or_more_members_from_a_sorted_set_returning_the_number_of_removed_members()
    {
        $key = 'some-key';
        $memberA = 'some-member';
        $memberB = 'some-other-member';

        for ($increment = 1; $increment <= 10; $increment++) {
            $this->redis->zincrby($key, 1, $memberA);
            $this->redis->zincrby($key, 2, $memberB);
        }

        $this->assertEquals(10, $this->redis->zscore($key, $memberA));
        $this->assertEquals(20, $this->redis->zscore($key, $memberB));

        $resultA = $this->redis->zrem($key, $memberA);
        $this->assertEquals(null, $this->redis->zscore($key, $memberA));
        $this->assertEquals(20, $this->redis->zscore($key, $memberB));
        $this->assertEquals(1, $resultA);

        $this->redis->zincrby($key, 1, $memberA);
        $this->assertEquals(1, $this->redis->zscore($key, $memberA));
        $this->assertEquals(20, $this->redis->zscore($key, $memberB));

        $resultB = $this->redis->zrem($key, [$memberA, $memberB]);
        $this->assertEquals(null, $this->redis->zscore($key, $memberA));
        $this->assertEquals(null, $this->redis->zscore($key, $memberB));
        $this->assertEquals(2, $resultB);
    }

    /** @test */
    public function zscores_return_value_can_be_overwritten()
    {
        $this->redis->shouldReturn(false);

        $this->assertFalse($this->redis->zscore('some-key', 'some-member'));
    }

    /** @test */
    public function lrange_gets_elements_from_a_list()
    {
        $this->assertEmpty($this->redis->lrange('some-key', 0, -1));

        $this->redis->rpush('some-key', 'some-value');
        $this->redis->rpush('some-key', 'some-other-value');

        $result = $this->redis->lrange('some-key', 0, -1);

        $this->assertCount(2, $result);
    }

    /** @test */
    public function lrange_returns_an_empty_array_if_no_elements_are_found()
    {
        $this->assertEmpty($this->redis->lrange('some-key', 0, -1));
    }

    /** @test */
    public function lrange_returns_subsets_of_lists()
    {
        $this->redis->rpush('key', 'valueA');
        $this->redis->rpush('key', 'valueB');
        $this->redis->rpush('key', 'valueC');
        $this->redis->rpush('key', 'valueD');
        $this->redis->rpush('key', 'valueE');

        $resultA = collect($this->redis->lrange('key', 0, 0));
        $this->assertCount(1, $resultA);
        $this->assertEquals('valueA', $resultA->shift());

        $resultB = collect($this->redis->lrange('key', 0, -2));
        $this->assertCount(4, $resultB);
        $this->assertEquals('valueA', $resultB->shift());
        $this->assertEquals('valueB', $resultB->shift());
        $this->assertEquals('valueC', $resultB->shift());
        $this->assertEquals('valueD', $resultB->shift());
        $this->assertNull($resultB->shift());

        $resultC = collect($this->redis->lrange('key', 0, -1000));
        $this->assertEmpty($resultC);

        $resultD = collect($this->redis->lrange('key', 0, 1000));
        $this->assertCount(5, $resultD);
        $this->assertEquals('valueA', $resultD->shift());
        $this->assertEquals('valueB', $resultD->shift());
        $this->assertEquals('valueC', $resultD->shift());
        $this->assertEquals('valueD', $resultD->shift());
        $this->assertEquals('valueE', $resultD->shift());

        $resultE = collect($this->redis->lrange('key', 1000, -1));
        $this->assertEmpty($resultE);
    }

    /** @test */
    public function it_lranges_return_value_can_be_overwritten()
    {
        $this->redis->shouldReturn(false);

        $this->assertFalse($this->redis->lrange('some-key', 0, -1));
    }

    /** @test */
    public function rpush_appends_a_value_to_a_list()
    {
        $this->redis->rpush('some-key', 'some-value');
        $this->redis->rpush('some-key', 'some-other-value');

        $result = collect($this->redis->lrange('some-key', 0, -1));

        $this->assertCount(2, $result);
        $this->assertEquals('some-value', $result->shift());
        $this->assertEquals('some-other-value', $result->shift());
    }

    /** @test */
    public function hset_sets_a_value_for_a_field_and_key_in_a_hash()
    {
        // Return value is 1 if key and field is set for the first time
        $result = $this->redis->hset('some-key', 'some-field', 'some-value');

        $this->assertEquals(1, $result);

        // Return value is 0 if key and field is overridden
        $result = $this->redis->hset('some-key', 'some-field', 'some-value');

        $this->assertEquals(0, $result);
    }

    /** @test */
    public function hexists_checks_if_a_hash_key_and_field_exists()
    {
        $this->assertFalse($this->redis->hexists('some-key', 'some-field'));

        $this->redis->hset('some-key', 'some-field', 'some-value');

        $this->assertTrue($this->redis->hexists('some-key', 'some-field'));
    }

    /** @test */
    public function hget_gets_a_value_of_a_key_and_field()
    {
        $this->redis->hset('some-key', 'some-field', 'some-value');

        $value = $this->redis->hget('some-key', 'some-field');

        $this->assertEquals('some-value', $value);
    }

    /** @test */
    public function hget_returns_null_if_no_value_exists_for_key_and_field()
    {
        $value = $this->redis->hget('some-key', 'some-field');

        $this->assertNull($value);
    }

    /** @test */
    public function sadd_appends_a_value_to_a_set()
    {
        $this->redis->sadd('some-key', 'some-value');
        $this->redis->sadd('some-key', 'some-other-value');

        $result = collect($this->redis->smembers('some-key'));

        $this->assertCount(2, $result);
        $this->assertEquals('some-value', $result->shift());
        $this->assertEquals('some-other-value', $result->shift());
    }

    /** @test */
    public function sadd_returns_the_number_of_elements_added_to_a_set()
    {
        $result = $this->redis->sadd('some-key', 'some-value');

        $this->assertEquals(1, $result);
    }

    /** @test */
    public function sadd_returns_zero_if_value_exists_in_set()
    {
        $result = $this->redis->sadd('some-key', 'some-value');
        $this->assertEquals(1, $result);

        $result = $this->redis->sadd('some-key', 'some-value');
        $this->assertEquals(0, $result);
    }

    /** @test */
    public function smember_returns_an_empty_array_if_key_does_not_exist()
    {
        $this->assertEquals([], $this->redis->smembers('key-that-does-not-exist'));
    }

    /** @test */
    public function the_same_value_cannot_be_added_to_a_set_twice()
    {
        $this->redis->sadd('some-key', 'some-value');
        $this->redis->sadd('some-key', 'some-other-value');
        $this->redis->sadd('some-key', 'some-other-value');

        $result = collect($this->redis->smembers('some-key'));

        $this->assertCount(2, $result);
        $this->assertEquals('some-value', $result->shift());
        $this->assertEquals('some-other-value', $result->shift());
    }

    /** @test */
    public function set_can_set_a_value_for_a_specific_key_and_returns_ok_if_successful()
    {
        $result = $this->redis->set('some-key', 'some-value');

        $this->assertEquals('OK', $result);
    }

    /** @test */
    public function get_returns_the_value_at_a_specific_key()
    {
        $this->redis->set('some-key', 'some-value');
        $value = $result = $this->redis->get('some-key');

        $this->assertEquals('some-value', $value);
    }

    /** @test */
    public function get_return_null_if_key_has_not_been_set()
    {
        $value = $result = $this->redis->get('some-key');

        $this->assertNull($value);
    }

    /** @test */
    public function exists_returns_one_if_a_certain_key_exists_in_redis()
    {
        $this->redis->set('some-key', 'some-value');

        $this->assertEquals(1, $this->redis->exists('some-key'));
    }

    /** @test */
    public function exists_returns_zero_if_a_certain_key_exists_in_redis()
    {
        $this->assertEquals(0, $this->redis->exists('some-key'));
        $this->assertNotNull($this->redis->exists('some-key'));
    }

    /** @test */
    public function llen_will_return_the_length_of_the_list_stored_at_key()
    {
        $this->redis->rpush('some-key', 'some-value');
        $this->redis->rpush('some-key', 'some-other-value');

        $this->assertEquals(2, $this->redis->llen('some-key'));
    }

    /** @test */
    public function ltrim_trims_an_existing_list_to_only_contain_the_specified_range()
    {
        $this->redis->rpush('some-key', 'some-first-value');
        $this->redis->rpush('some-key', 'some-second-value');
        $this->redis->rpush('some-key', 'some-third-value');

        $this->redis->ltrim('some-key', 1, -1);
        $result = collect($this->redis->lrange('some-key', 0, -1));

        $this->assertEquals('some-second-value', $result->shift());
        $this->assertEquals('some-third-value', $result->shift());
    }

    /** @test */
    public function ltrim_clears_a_list_if_start_is_larger_than_stop()
    {
        $this->redis->rpush('some-key', 'some-first-value');
        $this->redis->rpush('some-key', 'some-second-value');
        $this->redis->rpush('some-key', 'some-third-value');

        $this->redis->ltrim('some-key', 10, -1);
        $result = collect($this->redis->lrange('some-key', 0, -1));

        $this->assertCount(0, $result);
    }

    /** @test */
    public function ltrim_ignores_if_stop_is_too_large_and_simply_sees_it_as_the_end_of_the_list()
    {
        $this->redis->rpush('some-key', 'some-first-value');
        $this->redis->rpush('some-key', 'some-second-value');
        $this->redis->rpush('some-key', 'some-third-value');

        $this->redis->ltrim('some-key', 0, 10);
        $result = collect($this->redis->lrange('some-key', 0, -1));

        $this->assertCount(3, $result);
    }

    /** @test */
    public function hsetnx_returns_one_if_field_does_not_exist_in_hash()
    {
        $result = $this->redis->hsetnx('some-hash', 'some-field', 'some-value');

        $this->assertEquals(1, $result);
    }

    /** @test */
    public function hsetnx_returns_zero_if_field_exists_in_hash()
    {
        $firstResult = $this->redis->hsetnx('some-hash', 'some-field', 'some-value');
        $secondResult = $this->redis->hsetnx('some-hash', 'some-field', 'some-value');

        $this->assertEquals(1, $firstResult);
        $this->assertEquals(0, $secondResult);
    }

    /** @test */
    public function ltrim_returns_the_string_ok()
    {
        $this->redis->rpush('some-key', 'some-first-value');
        $this->redis->rpush('some-key', 'some-second-value');
        $this->redis->rpush('some-key', 'some-third-value');

        $result = $this->redis->ltrim('some-key', 1, -1);

        $this->assertEquals('OK', $result);
    }

    /** @test */
    public function operations_can_be_run_in_a_pipeline()
    {
        // As of now we only have need for running zincrby() in a pipeline
        // so this is the only operation supported by the mock atm.
        // Feel free to add support for other operations as needed

        $result = $this->redis->pipeline(function ($redis) {
            /** @var RedisMock $redis */
            $redis->zincrby('some-key', 100, 'some-member');
            $redis->zincrby('some-key', 100, 'some-member');
        });

        $this->assertEquals([
            0 => 100,
            1 => 200,
        ], $result);
    }

    /** @test */
    public function it_can_flush_all_keys()
    {
        $this->redis->set('some-key', 'some-first-value');
        $this->redis->set('some-other-key', 'some-second-value');
        $this->redis->set('some-third-key', 'some-third-value');

        $this->redis->flushAll();

        $this->assertEquals(0, $this->redis->exists('some-key'));
        $this->assertEquals(0, $this->redis->exists('some-other-key'));
        $this->assertEquals(0, $this->redis->exists('some-third-key'));
    }

    /** @test */
    public function zrange_return_an_empty_array_if_key_does_not_exist()
    {
        $result = $this->redis->zrange('some-key');

        $this->assertEmpty($result);
        $this->assertTrue(is_array($result), 'Result of zrange is not an array');
        $this->assertNotNull($result);
    }

    /** @test */
    public function zrange_return_an_empty_array_if_start_is_larger_than_the_number_of_members_in_the_set()
    {
        $this->redis->zincrby('some-key', 1, 'memberA');
        $this->redis->zincrby('some-key', 1, 'memberB');
        $this->redis->zincrby('some-key', 1, 'memberC');

        $result = $this->redis->zrange('some-key', 4, -1);

        $this->assertEmpty($result);
        $this->assertTrue(is_array($result), 'Result of zrange is not an array');
        $this->assertNotNull($result);
    }

    /** @test */
    public function zrange_return_an_empty_array_if_start_is_larger_than_end()
    {
        $this->redis->zincrby('some-key', 1, 'memberA');
        $this->redis->zincrby('some-key', 1, 'memberB');
        $this->redis->zincrby('some-key', 1, 'memberC');

        $result = $this->redis->zrange('some-key', 2, 0);

        $this->assertEmpty($result);
        $this->assertTrue(is_array($result), 'Result of zrange is not an array');
        $this->assertNotNull($result);
    }

    /** @test */
    public function zrange_returns_all_member_for_a_specific_key()
    {
        $this->redis->zincrby('some-key', 1, 'memberB');
        $this->redis->zincrby('some-key', 1, 'memberC');
        $this->redis->zincrby('some-key', 1, 'memberC');
        $this->redis->zincrby('some-key', 1, 'memberC');
        $this->redis->zincrby('some-key', 1, 'memberB');
        $this->redis->zincrby('some-key', 1, 'memberA');

        $result = $this->redis->zrange('some-key');

        $this->assertCount(3, $result);
        $this->assertEquals('memberC', reset($result));
    }

    /** @test */
    public function zrange_returns_all_member_for_a_specific_key_with_their_score()
    {
        $this->redis->zincrby('some-key', 1, 'memberB');
        $this->redis->zincrby('some-key', 1, 'memberC');
        $this->redis->zincrby('some-key', 1, 'memberC');
        $this->redis->zincrby('some-key', 1, 'memberB');
        $this->redis->zincrby('some-key', 1, 'memberA');

        $result = $this->redis->zrange('some-key', 0, -1, true);

        $this->assertCount(6, $result);

        $this->assertEquals('memberB', array_shift($result));
        $this->assertEquals(2, array_shift($result));

        $this->assertEquals('memberC', array_shift($result));
        $this->assertEquals(2, array_shift($result));

        $this->assertEquals('memberA', array_shift($result));
        $this->assertEquals(1, array_shift($result));
    }

    /** @test */
    public function zadd_updates_or_sets_a_score_for_a_member_on_a_key()
    {
        $this->redis->zincrby('some-key', 1, 'memberA');
        $this->redis->zincrby('some-key', 1, 'memberA');
        $this->redis->zincrby('some-key', 1, 'memberA');
        $this->assertEquals(3, $this->redis->zscore('some-key', 'memberA'));

        $this->redis->zadd('some-key', 5, 'memberA');

        $this->assertEquals(5, $this->redis->zscore('some-key', 'memberA'));
    }

    /** @test */
    public function zadd_returns_0_if_it_updates_an_existing_member()
    {
        $this->redis->zincrby('some-key', 1, 'memberA');
        $result = $this->redis->zadd('some-key', 5, 'memberA');

        $this->assertEquals(0, $result);
    }

    /** @test */
    public function zadd_returns_1_if_it_sets_a_new_member()
    {
        $result = $this->redis->zadd('some-key', 5, 'memberA');

        $this->assertEquals(1, $result);
    }

    /** @test */
    public function it_can_execute_funneled_methods()
    {
        Redis::funnel("myKey")
            ->limit(1)
            ->releaseAfter(60)
            ->block(5)
            ->then(function (){
                $this->assertTrue(true); // We entered the correct closure
            }, function ($exception) {
                $this->assertTrue(false); // We entered the wrong closure
            });
    }

    /** @test */
    public function it_can_catch_funnel_exceptions_and_run_error_code()
    {
        Redis::funnel("myKey")
            ->limit(1)
            ->releaseAfter(60)
            ->block(5)
            ->then(function (){
                throw new \Exception("Exception to enter failure closure");

                $this->assertTrue(false);
            }, function ($exception) {
                $this->assertTrue(true); // We entered the correct closure
            });
    }
}
