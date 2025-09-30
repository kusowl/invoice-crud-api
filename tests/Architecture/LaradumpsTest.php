<?php
arch('does not use debug functions')
    ->expect(['ds', 'dsd', 'dsq', 'dd', 'ddd', 'dump', 'ray', 'die', 'var_dump', 'sleep', 'exit'])
    ->not
    ->toBeUsed();
