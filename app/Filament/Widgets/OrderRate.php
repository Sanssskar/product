<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Carbon\Carbon;

class OrderRate extends ChartWidget
{
    protected ?string $heading = 'Order Rate';
    protected static ?int $sort = 2;
    protected string|array|int $columnSpan = 'full';

    // Default filter = current year
    public ?string $filter = null;

    public function mount(): void
    {
        $this->filter = (string) now()->year;
    }

    protected function getFilters(): ?array
    {
        $filters = [
            'week'  => 'This Week',
            'month' => 'This Month',
        ];

        $currentYear = now()->year;

        // Add current year + 4 previous years
        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $filters[(string) $y] = (string) $y;
        }

        return $filters;
    }

    protected function getData(): array
    {
        if ($this->filter === 'week') {
            return $this->getWeeklyData();
        }

        if ($this->filter === 'month') {
            return $this->getMonthlyData();
        }

        // If filter is a year (e.g. "2025", "2024", ...)
        return $this->getYearlyData((int) $this->filter);
    }

    private function getWeeklyData(): array
    {
        $startOfWeek = now()->startOfWeek();

        $labels = [];
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $labels[] = $date->format('D'); // Mon, Tue, ...
            $data[] = Order::whereDate('created_at', $date)->count();
        }

        return $this->chartFormat($labels, $data, 'Orders This Week');
    }

    private function getMonthlyData(): array
    {
        $start = now()->startOfMonth();
        $daysInMonth = now()->daysInMonth;

        $labels = [];
        $data = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $start->copy()->addDays($i - 1);
            $labels[] = $date->format('j'); // 1, 2, ..., 31
            $data[] = Order::whereDate('created_at', $date)->count();
        }

        return $this->chartFormat($labels, $data, 'Orders This Month');
    }

    private function getYearlyData(int $year): array
    {
        $monthlyCounts = Order::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        $labels = [];
        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $labels[] = Carbon::create()->month($month)->format('M');
            $data[] = $monthlyCounts[$month] ?? 0;
        }

        return $this->chartFormat($labels, $data, "Orders {$year}");
    }

    private function chartFormat(array $labels, array $data, string $label): array
    {
        return [
            'datasets' => [
                [
                    'label'           => $label,
                    'data'            => $data,
                    'borderColor'     => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
