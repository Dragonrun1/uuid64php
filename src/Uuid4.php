<?php
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

namespace Uuid64Php;

use Exception;
use LengthException;

/**
 * Trait Uuid4.
 */
trait Uuid4 {
    /**
     * Generate a custom base 64 encoded UUID v4 (random).
     *
     * @return string  Returns a custom base 64 encoded UUID v4.
     * @throws Exception
     * @api
     */
    protected function asBase64(): string {
        $binString = '0000' . $this->asBinString();
        $result = '';
        $pieces = str_split($binString, 6);
        foreach ($pieces as $k => $piece) {
            $result .= static::$base64[$piece];
        }
        return $result;
    }
    /**
     * Helper method for the common parts of creating new UUID in binary form.
     *
     * @return string
     * @throws Exception
     * @private
     */
    protected function asBinString(): string {
        if (0 === count($this->uuid0)) {
            $this->initUuid();
        }
        $binArray = $this->uuid0;
        $binary = '';
        foreach ($binArray as $value) {
            //$binary .= str_pad(decbin($value), 8, '0', STR_PAD_LEFT);
            $binary .= sprintf('%08b', $value);
        }
        return $binary;
    }
    /**
     * Generate a hexadecimal encoded UUID v4 (random).
     *
     * @return string Returns a hexadecimal encoded UUID v4.
     * @throws Exception
     * @api
     */
    protected function asHexString(): string {
        $binString = $this->asBinString();
        $hexString = '';
        $pieces = str_split($binString, 16);
        foreach ($pieces as $piece) {
            $hexString .= sprintf('%04x', bindec($piece));
        }
        return $hexString;
    }
    /**
     * Generate a standard UUID v4 (random).
     *
     * Original code for the function was found in answer at
     * https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
     * by Arie which is based on a function found at
     * http://php.net/manual/en/function.com-create-guid.php
     * by pavel.volyntsev(at)gmail.
     *
     * Many other changes since the above code and changes.
     *
     * @return string Returns a standard UUID v4.
     * @throws Exception
     * @api
     */
    protected function asUuid(): string {
        $hex_pieces = $this->asHexString();
        $pieces = [8, 4, 4, 4, 12];
        $hex_string = [];
        $last = 0;
        foreach ($pieces as $piece) {
            $hex_string[] = substr($hex_pieces, $last, $piece);
            $last += $piece;
        }
        $hex_string = implode('-', $hex_string);
        return $hex_string;
    }
    /**
     * @param array<int>|null $data Should normally be `null` to create a truly
     *                              random v4 UUID.
     *
     * @throws Exception
     * @api
     */
    protected function initUuid(?array $data = null): void {
        $binArray = $data ?? array_map(static function ($c) {
                return ord($c);
            }, str_split(random_bytes(16)));
        if (16 !== count($binArray)) {
            $mess = 'Expected data array length of 16 but was given length: ' . count($binArray);
            throw new LengthException($mess);
        }
        $binArray[6] = ($binArray[6] & 0x0f) | 0x40;
        $binArray[8] = ($binArray[8] & 0x3f) | 0x80;
        $this->uuid0 = array_reverse($binArray);
    }
    /**
     * @var string[]
     */
    protected static array $base64 = [
        '000000' => 'A',
        '000001' => 'B',
        '000010' => 'C',
        '000011' => 'D',
        '000100' => 'E',
        '000101' => 'F',
        '000110' => 'G',
        '000111' => 'H',
        '001000' => 'I',
        '001001' => 'J',
        '001010' => 'K',
        '001011' => 'L',
        '001100' => 'M',
        '001101' => 'N',
        '001110' => 'O',
        '001111' => 'P',
        '010000' => 'Q',
        '010001' => 'R',
        '010010' => 'S',
        '010011' => 'T',
        '010100' => 'U',
        '010101' => 'V',
        '010110' => 'W',
        '010111' => 'X',
        '011000' => 'Y',
        '011001' => 'Z',
        '011010' => 'a',
        '011011' => 'b',
        '011100' => 'c',
        '011101' => 'd',
        '011110' => 'e',
        '011111' => 'f',
        '100000' => 'g',
        '100001' => 'h',
        '100010' => 'i',
        '100011' => 'j',
        '100100' => 'k',
        '100101' => 'l',
        '100110' => 'm',
        '100111' => 'n',
        '101000' => 'o',
        '101001' => 'p',
        '101010' => 'q',
        '101011' => 'r',
        '101100' => 's',
        '101101' => 't',
        '101110' => 'u',
        '101111' => 'v',
        '110000' => 'w',
        '110001' => 'x',
        '110010' => 'y',
        '110011' => 'z',
        '110100' => '0',
        '110101' => '1',
        '110110' => '2',
        '110111' => '3',
        '111000' => '4',
        '111001' => '5',
        '111010' => '6',
        '111011' => '7',
        '111100' => '8',
        '111101' => '9',
        '111110' => '-',
        '111111' => '_',
    ];
    protected array $uuid0 = [];
}
