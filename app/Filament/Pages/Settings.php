<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    // protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'erp.nav.settings';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('erp.settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('erp.nav_settings'); // fallback to simple translation strategy
    }

    public function getTitle(): string
    {
        return __('erp.settings');
    }

    public function mount(): void
    {
        $prefs = Auth::user()->preference;
        $this->form->fill([
            'theme' => $prefs->theme ?? 'royal-brown',
            'locale' => $prefs->locale ?? 'en',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('theme')
                    ->label(__('erp.theme'))
                    ->options([
                        'royal-brown' => __('erp.theme_royal_brown'),
                        'emerald' => __('erp.theme_emerald'),
                        'sapphire' => __('erp.theme_sapphire'),
                    ])
                    ->required(),
                Select::make('locale')
                    ->label(__('erp.language'))
                    ->options([
                        'en' => __('erp.english'),
                        'ar' => __('erp.arabic'),
                    ])
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        $prefs = $user->preference ?? new \App\Models\UserPreference();
        $prefs->user_id = $user->id;
        $prefs->theme = $data['theme'];
        $prefs->locale = $data['locale'];
        $prefs->save();

        Notification::make()
            ->title(__('erp.settings_saved'))
            ->success()
            ->send();

        $this->redirect(request()->header('Referer'));
    }
}
