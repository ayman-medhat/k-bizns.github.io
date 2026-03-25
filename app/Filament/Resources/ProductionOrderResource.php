<?php

namespace App\Filament\Resources;

use App\Models\ProductionOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductionOrderResource extends Resource
{
    protected static ?string $model = ProductionOrder::class;
    // protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'erp.nav.manufacturing';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.production_order');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.production_orders');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.order_details'))->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('number')
                        ->label(__('erp.po_number'))
                        ->default(fn() => ProductionOrder::generateNumber())
                        ->disabled()
                        ->dehydrated()
                        ->required(),
                    Forms\Components\Select::make('bom_id')
                        ->label(__('erp.bom'))
                        ->relationship('bom', 'reference')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->label(__('erp.status'))
                        ->options([
                            'draft' => __('erp.draft'),
                            'confirmed' => __('erp.confirmed'),
                            'in_progress' => __('erp.in_progress'),
                            'done' => __('erp.done'),
                            'cancelled' => __('erp.cancelled'),
                        ])
                        ->default('draft')
                        ->required(),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('quantity')
                        ->label(__('erp.quantity'))
                        ->numeric()
                        ->default(1)
                        ->required(),
                    Forms\Components\DatePicker::make('start_date')
                        ->label(__('erp.start_date'))
                        ->default(now())
                        ->required(),
                    Forms\Components\DatePicker::make('end_date')
                        ->label(__('erp.end_date')),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('erp.po_number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bom.reference')
                    ->label(__('erp.bom'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('erp.quantity'))
                    ->numeric(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('erp.start_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('erp.status'))
                    ->badge()
                    ->colors([
                        'info' => 'draft',
                        'warning' => 'confirmed',
                        'primary' => 'in_progress',
                        'success' => 'done',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => __('erp.draft'),
                        'confirmed' => __('erp.confirmed'),
                        'in_progress' => __('erp.in_progress'),
                        'done' => __('erp.done'),
                        'cancelled' => __('erp.cancelled'),
                    ]),
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
            'index' => \App\Filament\Resources\ProductionOrderResource\Pages\ListProductionOrders::route('/'),
            'create' => \App\Filament\Resources\ProductionOrderResource\Pages\CreateProductionOrder::route('/create'),
            'edit' => \App\Filament\Resources\ProductionOrderResource\Pages\EditProductionOrder::route('/{record}/edit'),
        ];
    }
}
