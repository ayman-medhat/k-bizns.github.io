<?php

namespace App\Filament\Resources;

use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    // protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'erp.nav.inventory';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.warehouse');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.warehouses');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.warehouse_details'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('erp.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('location')
                        ->label(__('erp.location'))
                        ->maxLength(255),
                ]),
                Forms\Components\Select::make('manager_id')
                    ->label(__('erp.manager'))
                    ->relationship('manager', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('erp.active'))
                    ->default(true),
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
                Tables\Columns\TextColumn::make('location')
                    ->label(__('erp.location'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('manager.name')
                    ->label(__('erp.manager'))
                    ->searchable(),
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
            'index' => \App\Filament\Resources\WarehouseResource\Pages\ListWarehouses::route('/'),
            'create' => \App\Filament\Resources\WarehouseResource\Pages\CreateWarehouse::route('/create'),
            'edit' => \App\Filament\Resources\WarehouseResource\Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
