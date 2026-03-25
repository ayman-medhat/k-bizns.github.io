<?php

namespace App\Filament\Resources;

use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;
    // protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'erp.nav.purchases';
    protected static ?int $navigationSort = 1;

    public static function getLabel(): string
    {
        return __('erp.vendor');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.vendors');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.vendor_info'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('erp.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label(__('erp.email'))
                        ->email()
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label(__('erp.phone'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('tax_number')
                        ->label(__('erp.tax_number'))
                        ->maxLength(255),
                ]),
                Forms\Components\Textarea::make('address')
                    ->label(__('erp.address'))
                    ->rows(3),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('currency')
                        ->label(__('erp.currency'))
                        ->default('USD'),
                    Forms\Components\Toggle::make('is_active')
                        ->label(__('erp.active'))
                        ->default(true),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('erp.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('erp.email'))
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('erp.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('tax_number')
                    ->label(__('erp.tax_number')),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('erp.active'))
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('erp.active')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\VendorResource\Pages\ListVendors::route('/'),
            'create' => \App\Filament\Resources\VendorResource\Pages\CreateVendor::route('/create'),
            'edit' => \App\Filament\Resources\VendorResource\Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
