<?php

namespace App\Filament\Resources;

use App\Models\PurchaseOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    // protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'erp.nav.purchases';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.purchase_order');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.purchase_orders');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make(__('erp.order_details'))->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('number')
                            ->label(__('erp.po_number'))
                            ->default(fn() => PurchaseOrder::generateNumber())
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Forms\Components\Select::make('vendor_id')
                            ->label(__('erp.vendor'))
                            ->relationship('vendor', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label(__('erp.status'))
                            ->options([
                                'draft' => __('erp.draft'),
                                'confirmed' => __('erp.confirmed'),
                                'received' => __('erp.received'),
                                'cancelled' => __('erp.cancelled'),
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\DatePicker::make('order_date')
                            ->label(__('erp.order_date'))
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('expected_date')
                            ->label(__('erp.expected_date')),
                    ]),
                ]),

                Forms\Components\Section::make(__('erp.order_items'))->schema([
                    Forms\Components\Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Forms\Components\Grid::make(5)->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label(__('erp.product'))
                                    ->relationship('product', 'name_translations->en')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('unit_cost', \App\Models\Product::find($state)?->cost_price ?? 0))
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('quantity')
                                    ->label(__('erp.quantity'))
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, callable $get, Forms\Set $set) => $set('line_total', $state * $get('unit_cost'))),
                                Forms\Components\TextInput::make('unit_cost')
                                    ->label(__('erp.unit_cost'))
                                    ->numeric()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, callable $get, Forms\Set $set) => $set('line_total', $state * $get('quantity'))),
                                Forms\Components\TextInput::make('line_total')
                                    ->label(__('erp.total'))
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(),
                            ]),
                        ])
                        ->defaultItems(1)
                        ->columns(1),
                ]),
            ])->columnSpan(['lg' => fn(?PurchaseOrder $record) => $record === null ? 3 : 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make(__('erp.summary'))->schema([
                    Forms\Components\TextInput::make('subtotal')
                        ->label(__('erp.subtotal'))
                        ->numeric()
                        ->default(0)
                        ->readOnly(),
                    Forms\Components\TextInput::make('tax_amount')
                        ->label(__('erp.tax'))
                        ->numeric()
                        ->default(0),
                    Forms\Components\TextInput::make('total')
                        ->label(__('erp.total'))
                        ->numeric()
                        ->default(0)
                        ->readOnly(),
                ]),
            ])->columnSpan(['lg' => 1])->hidden(fn(?PurchaseOrder $record) => $record === null),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('erp.po_number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vendor.name')
                    ->label(__('erp.vendor'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('erp.order_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label(__('erp.total'))
                    ->money(fn($record) => $record->currency ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('erp.status'))
                    ->badge()
                    ->colors([
                        'info' => 'draft',
                        'warning' => 'confirmed',
                        'success' => 'received',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => __('erp.draft'),
                        'confirmed' => __('erp.confirmed'),
                        'received' => __('erp.received'),
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
            'index' => \App\Filament\Resources\PurchaseOrderResource\Pages\ListPurchaseOrders::route('/'),
            'create' => \App\Filament\Resources\PurchaseOrderResource\Pages\CreatePurchaseOrder::route('/create'),
            'edit' => \App\Filament\Resources\PurchaseOrderResource\Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
