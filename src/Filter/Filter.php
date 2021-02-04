<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    SyliusApiClient
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Filter;

use Diglin\Sylius\ApiClient\ExpressionLanguage\ExpressionLanguageProvider;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class Filter implements FilterInterface
{
    private $nameOfCriterion;
    private $value;

    /**
     * If $nameOfCriterion is an array, $value will be ignored
     */
    public function __construct(
        $nameOfCriterion,
        $value = ''
    )
    {
        $this->nameOfCriterion = $nameOfCriterion;
        $this->value = $value;
    }

    public function getCriteria(): array
    {
        if (is_string($this->nameOfCriterion) && strpos($this->nameOfCriterion, 'criteria') === false) {
            $this->nameOfCriterion = sprintf('criteria[%s]', $this->nameOfCriterion);
        } else if (is_array($this->nameOfCriterion)) {
            $interpreter = new ExpressionLanguage(null, [new ExpressionLanguageProvider()]);
            $this->nameOfCriterion = $interpreter->evaluate('build_filter_criteria(input)', ['input' => $this->nameOfCriterion]);
            list($this->nameOfCriterion, $this->value) = explode('=', $this->nameOfCriterion );
        }

        return [
            $this->nameOfCriterion => $this->value,
        ];
    }

}
