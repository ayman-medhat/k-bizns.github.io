<?php

namespace App\Filament\Resources;

use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'erp.nav.sales';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.invoice');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.invoices');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make(__('erp.invoice_details'))->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('number')
                            ->label(__('erp.invoice_number'))
                            ->default(fn() => Invoice::generateNumber())
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Forms\Components\Select::make('client_id')
                            ->label(__('erp.client'))
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label(__('erp.status'))
                            ->options([
                                'draft' => __('erp.draft'),
                                'sent' => __('erp.sent'),
                                'paid' => __('erp.paid'),
                                'overdue' => __('erp.overdue'),
                                'cancelled' => __('erp.cancelled'),
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\DatePicker::make('issue_date')
                            ->label(__('erp.issue_date'))
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('due_date')
                            ->label(__('erp.due_date')),
                    ]),
                ]),

                Forms\Components\Section::make(__('erp.invoice_items'))->schema([
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
                                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('unit_price', \App\Models\Product::find($state)?->sale_price ?? 0))
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('quantity')
                                    ->label(__('erp.quantity'))
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, callable $get, Forms\Set $set) => $set('line_total', $state * $get('unit_price'))),
                                Forms\Components\TextInput::make('unit_price')
                                    ->label(__('erp.unit_price'))
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
            ])->columnSpan(['lg' => fn(?Invoice $record) => $record === null ? 3 : 2]),

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
                    Forms\Components\TextInput::make('discount_amount')
                        ->label(__('erp.discount'))
                        ->numeric()
                        ->default(0),
                    Forms\Components\TextInput::make('total')
                        ->label(__('erp.total'))
                        ->numeric()
                        ->default(0)
                        ->readOnly(),
                    Forms\Components\TextInput::make('amount_paid')
                        ->label(__('erp.amount_paid'))
                        ->numeric()
                        ->default(0),
                ]),
            ])->columnSpan(['lg' => 1])->hidden(fn(?Invoice $record) => $record === null),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('erp.invoice_number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->label(__('erp.client'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->label(__('erp.issue_date'))
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
                        'warning' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                        'gray' => 'cancelled',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => __('erp.draft'),
                        'sent' => __('erp.sent'),
                        'paid' => __('erp.paid'),
                        'overdue' => __('erp.overdue'),
                        'cancelled' => __('erp.cancelled'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label(__('erp.download_pdf'))
                    ->icon('heroicon-o-arrow-down-tray')
                // Action will be implemented later
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
            'index' => \App\Filament\Resources\InvoiceResource\Pages\ListInvoices::route('/'),
            'create' => \App\Filament\Resources\InvoiceResource\Pages\CreateInvoice::route('/create'),
            'edit' => \App\Filament\Resources\InvoiceResource\Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
