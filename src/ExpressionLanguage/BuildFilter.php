<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    FWG - OroCRM
 * @copyright   2021 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class BuildFilter extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $input)
    {
        $function = <<<FUNC
\$f = function(array \$input, \$firstLevel = true) use (&\$f) {
        \$output = '';
        foreach (\$input as \$key => \$value) {
            \$output .= sprintf('[%s]', \$key);
            if (is_array(\$value)) {
                \$output .= call_user_func(\$f, \$value, false);
            } else {
                \$output .= sprintf('=%s', \$value);
            }
        }

        if (\$firstLevel) {
            return 'criteria' . \$output;
        }

        return \$output;
}
FUNC;

        return sprintf('(%s)($input)', $function);
    }

    private function evaluate(array $context, array $input = [], $firstLevel = true)
    {
        $output = '';
        foreach ($input as $key => $value) {
            $output .= sprintf('[%s]', $key);
            if (is_array($value)) {
                $output .= $this->evaluate($context, $value, false);
            } else {
                $output .= sprintf('=%s', $value);
            }
        }

        if ($firstLevel) {
            return 'criteria' . $output;
        }

        return $output;
    }
}
