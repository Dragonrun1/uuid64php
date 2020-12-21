<?php
/** @noinspection PhpUnused */
/** @noinspection PhpIllegalPsrClassPathInspection */
/** @noinspection PhpUndefinedMethodInspection */
declare(strict_types=1);
/**
 * Copyright © 2020-present, Michael Cummings
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * MIT License
 *
 * Copyright © 2020-present, Michael Cummings <mgcummings@yahoo.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Spec\Uuid64Php;

use PhpSpec\ObjectBehavior;

/**
 * Class Uuid4Spec
 *
 * @mixin MockUuid4
 *
 */
class Uuid4Spec extends ObjectBehavior {
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_encode_based64(): void {
        $expects = [
            "AAAAAAAAAAgABAAAAAAAAA",
            "D_________v_9P________",
            "APDw8PDw8Pjw9PDw8PDw8P",
            "Dw8PDw8PDwsPBA8PDw8PDw",
            "ABAwUJESFBgYFBIREJBQMB",
            "AjIiEgHx5GhURDQkFAPz4A",
            "AAIiEgHx5GhURDQkFAPz49",
            "AjIiEgHx5GhURDQkFAPwAA",
            "A1NDMyMTBqqWhHZmVkYwAA",
            "AANTQzMjEwqmlIZ2ZlZGMA",
        ];
        $inputs = $this->test_byte_array_data();
        for ($i = 0, $iMax = count($inputs); $i < $iMax; ++$i) {
            $expected = $expects[$i];
            $this->setUuid0($inputs[$i]);
            $this->getBase64()
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_encode_hex_string(): void {
        $expects = [
            "00000000000000800040000000000000",
            "ffffffffffffffbfff4fffffffffffff",
            "0f0f0f0f0f0f0f8f0f4f0f0f0f0f0f0f",
            "f0f0f0f0f0f0f0b0f040f0f0f0f0f0f0",
            "01030509112141818141211109050301",
            "232221201f1e468544434241403f3e00",
            "002221201f1e468544434241403f3e3d",
            "232221201f1e468544434241403f0000",
            "3534333231306aa96847666564630000",
            "00353433323130aa6948676665646300",
        ];
        $inputs = $this->test_byte_array_data();
        for ($i = 0, $iMax = count($inputs); $i < $iMax; ++$i) {
            $expected = $expects[$i];
            $this->setUuid0($inputs[$i]);
            $this->getHexString()
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_encode_uuid(): void {
        $expects = [
            "00000000-0000-0080-0040-000000000000",
            "ffffffff-ffff-ffbf-ff4f-ffffffffffff",
            "0f0f0f0f-0f0f-0f8f-0f4f-0f0f0f0f0f0f",
            "f0f0f0f0-f0f0-f0b0-f040-f0f0f0f0f0f0",
            "01030509-1121-4181-8141-211109050301",
            "23222120-1f1e-4685-4443-4241403f3e00",
            "00222120-1f1e-4685-4443-4241403f3e3d",
            "23222120-1f1e-4685-4443-4241403f0000",
            "35343332-3130-6aa9-6847-666564630000",
            "00353433-3231-30aa-6948-676665646300",
        ];
        $inputs = $this->test_byte_array_data();
        for ($i = 0, $iMax = count($inputs); $i < $iMax; ++$i) {
            $expected = $expects[$i];
            $this->setUuid0($inputs[$i]);
            $this->getUuid()
                 ->shouldReturn($expected);
        }
    }
    public function let(): void {
        $this->beAnInstanceOf(MockUuid4::class);
    }
    private function test_byte_array_data(): array {
        return [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255],
            [15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15],
            [240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240],
            [1, 3, 5, 9, 17, 33, 65, 129, 129, 65, 33, 17, 9, 5, 3, 1],
            [0, 62, 63, 64, 65, 66, 67, 68, 69, 70, 30, 31, 32, 33, 34, 35],
            [61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 30, 31, 32, 33, 34, 0],
            [0, 0, 63, 64, 65, 66, 67, 68, 69, 70, 30, 31, 32, 33, 34, 35],
            [0, 0, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
            [0, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53, 0],
        ];
    }
}
