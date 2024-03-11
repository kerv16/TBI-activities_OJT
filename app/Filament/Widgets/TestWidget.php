<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Charts\Chart;



class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', Post::count())
                ->descriptionIcon('heroicon-o-clipboard-document-list', IconPosition::Before)
                ->description('The total number of posts')
                ->color('success'),
            Stat::make('Total Users', User::count())
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before,)
                ->description('The total number of users')
                ->color('warning'),
            Stat::make('Total number of Categories', Category::count())
                ->descriptionIcon('heroicon-o-tag', IconPosition::Before)
                ->description('The total number of categories')
                ->color('info'),
        ];
    }
}
