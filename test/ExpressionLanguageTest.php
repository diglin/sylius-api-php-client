<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    SyliusApiClient
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Test;

use Diglin\Sylius\ApiClient\ExpressionLanguage\ExpressionLanguageProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionLanguageTest extends TestCase
{
    public function dataProvider()
    {
        yield [
            'criteria[date][from][date]=2021-02-04',
            [
                'date' => [
                    'from' => [
                        'date' => '2021-02-04',
                    ],
                ],
            ],
            'build_filter_criteria(input)',
        ];

        yield [
            'criteria[date][to][date]=2021-02-05',
            [
                'date' => [
                    'to' => [
                        'date' => '2021-02-05',
                    ],
                ],
            ],
            'build_filter_criteria(input)',
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testBuildFilter(string $expected, array $input, string $expression)
    {
        $interpreter = new ExpressionLanguage(null, [new ExpressionLanguageProvider()]);

        $this->assertEquals($expected, $interpreter->evaluate($expression, ['input' => $input]));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCompiledFilter(string $expected, array $input, string $expression)
    {
        $interpreter = new ExpressionLanguage(null, [new ExpressionLanguageProvider()]);

        $compiled = include 'data://application/x-php;base64,' . base64_encode($sources = '<?php return function(array $input) {return ' . ($interpreter->compile($expression, ['input'])) . ';};');

        $this->assertEquals($expected, $compiled($input));
    }
}
