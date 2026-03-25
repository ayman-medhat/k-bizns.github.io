<?php

namespace App\Filament\Resources;

use App\Models\StockMovement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;
    // protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'erp.nav.inventory';
    protected static ?int $navigationSort = 3;

    public static function getLabel(): string
    {
        return __('erp.stock_movement');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.stock_movements');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.movement_details'))->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Select::make('product_id')
                        ->label(__('erp.product'))
                        ->relationship('product', 'name_translations->en')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('warehouse_id')
                        ->label(__('erp.warehouse'))
                        ->relationship('warehouse', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('type')
                        ->label(__('erp.type'))
                        ->options([
                            'in' => __('erp.in'),
                            'out' => __('erp.out'),
                            'transfer' => __('erp.transfer'),
                            'adjust' => __('erp.adjust'),
                        ])
                        ->default('in')
                        ->required(),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('quantity')
                        ->label(__('erp.quantity'))
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('reference')
                        ->label(__('erp.reference'))
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('date')
                        ->label(__('erp.date'))
                        ->default(now())
                        ->required(),
                ]),
                Forms\Components\Textarea::make('notes')
                    ->label(__('erp.notes'))
                    ->rows(3),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name_translations.en')
                    ->label(__('erp.product'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label(__('erp.warehouse'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('erp.type'))
                    ->badge()
                    ->colors([
                        'success' => 'in',
                        'danger' => 'out',
                        'warning' => 'transfer',
                        'info' => 'adjust',
                    ]),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('erp.quantity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('erp.date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->label(__('erp.reference'))
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'in' => __('erp.in'),
                        'out' => __('erp.out'),
                        'transfer' => __('erp.transfer'),
                        'adjust' => __('erp.adjust'),
                    ]),
                Tables\Filters\SelectFilter::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->label(__('erp.warehouse')),
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
            'index' => \App\Filament\Resources\StockMovementResource\Pages\ListStockMovements::route('/'),
            'create' => \App\Filament\Resources\StockMovementResource\Pages\CreateStockMovement::route('/create'),
            'edit' => \App\Filament\Resources\StockMovementResource\Pages\EditStockMovement::route('/{record}/edit'),
        ];
    }
}
