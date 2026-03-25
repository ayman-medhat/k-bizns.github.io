<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Settings;
use App\Filament\Resources\AccountResource;
use App\Filament\Resources\BillResource;
use App\Filament\Resources\BOMResource;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ContactResource;
use App\Filament\Resources\DealResource;
use App\Filament\Resources\LeadResource;
use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\InvoiceResource;
use App\Filament\Resources\JournalEntryResource;
use App\Filament\Resources\JournalResource;
use App\Filament\Resources\PayrollPeriodResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductionOrderResource;
use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\PurchaseOrderResource;
use App\Filament\Resources\SalesOrderResource;
use App\Filament\Resources\StockMovementResource;
use App\Filament\Resources\TaskResource;
use App\Filament\Resources\TimesheetResource;
use App\Filament\Resources\VendorResource;
use App\Filament\Resources\WarehouseResource;
use App\Filament\Widgets\ActiveProjectWidget;
use App\Filament\Widgets\RecentActivitiesWidget;
use App\Filament\Widgets\RevenueByCategory;
use App\Filament\Widgets\SalesChartWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\TaskListWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('erp')
            ->login()
            ->colors([
                'primary' => Color::hex('#D2B48C'),
                'gray' => Color::hex('#9CA3AF'),
                'info' => Color::hex('#60A5FA'),
                'success' => Color::hex('#34D399'),
                'warning' => Color::hex('#FBBF24'),
                'danger' => Color::hex('#F87171'),
            ])
            ->font('Inter')
            ->brandName('Kashmos ERP')
            ->brandLogo(fn() => view('filament.brand'))
            ->darkMode(true)
            ->navigationGroups([
                NavigationGroup::make(__('erp.nav.crm'))->icon('heroicon-o-users'),
                NavigationGroup::make(__('erp.nav.sales'))->icon('heroicon-o-shopping-cart'),
                NavigationGroup::make(__('erp.nav.inventory'))->icon('heroicon-o-cube'),
                NavigationGroup::make(__('erp.nav.purchases'))->icon('heroicon-o-truck'),
                NavigationGroup::make(__('erp.nav.accounting'))->icon('heroicon-o-banknotes'),
                NavigationGroup::make(__('erp.nav.hr'))->icon('heroicon-o-identification'),
                NavigationGroup::make(__('erp.nav.projects'))->icon('heroicon-o-briefcase'),
                NavigationGroup::make(__('erp.nav.manufacturing'))->icon('heroicon-o-cog-6-tooth'),
                NavigationGroup::make(__('erp.nav.settings'))->icon('heroicon-o-wrench-screwdriver'),
            ])
            ->resources([
                    // CRM
                ContactResource::class,
                ClientResource::class,
                DealResource::class,
                LeadResource::class,
                    // Sales
                SalesOrderResource::class,
                InvoiceResource::class,
                    // Inventory
                ProductResource::class,
                WarehouseResource::class,
                StockMovementResource::class,
                    // Purchases
                VendorResource::class,
                PurchaseOrderResource::class,
                BillResource::class,
                    // Accounting
                AccountResource::class,
                JournalResource::class,
                JournalEntryResource::class,
                    // HR
                EmployeeResource::class,
                PayrollPeriodResource::class,
                    // Projects
                ProjectResource::class,
                TaskResource::class,
                TimesheetResource::class,
                    // Manufacturing
                BOMResource::class,
                ProductionOrderResource::class,
            ])
            ->pages([Settings::class])
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\SetLocaleFromPreference::class,
                \App\Http\Middleware\ApplyTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->renderHook('panels::body.end', fn() => view('filament.footer'));
    }
}
