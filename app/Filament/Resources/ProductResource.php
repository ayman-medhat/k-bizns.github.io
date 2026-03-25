<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    // protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'erp.nav.inventory';
    protected static ?int $navigationSort = 1;

    public static function getLabel(): string
    {
        return __('erp.products');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.products');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.basic_info'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name_translations.en')
                        ->label(__('erp.name_en'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('name_translations.ar')
                        ->label(__('erp.name_ar'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Textarea::make('description_translations.en')
                        ->label(__('erp.description_en'))
                        ->rows(3),
                    Forms\Components\Textarea::make('description_translations.ar')
                        ->label(__('erp.description_ar'))
                        ->rows(3),
                ]),
            ]),
            Forms\Components\Section::make(__('erp.pricing_stock'))->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('sku')
                        ->label(__('erp.sku'))
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('type')
                        ->label(__('erp.type'))
                        ->options([
                            'storable' => __('erp.storable'),
                            'service' => __('erp.service'),
                            'consumable' => __('erp.consumable'),
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('unit')
                        ->label(__('erp.unit')),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('sale_price')
                        ->label(__('erp.sale_price'))
                        ->numeric()
                        ->prefix('$'),
                    Forms\Components\TextInput::make('cost_price')
                        ->label(__('erp.cost_price'))
                        ->numeric()
                        ->prefix('$'),
                    Forms\Components\TextInput::make('min_stock')
                        ->label(__('erp.min_stock'))
                        ->numeric(),
                ]),
            ]),
            Forms\Components\Section::make(__('erp.settings'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('category')
                        ->label(__('erp.category')),
                    Forms\Components\Toggle::make('is_active')
                        ->label(__('erp.active'))
                        ->default(true),
                ]),
                Forms\Components\FileUpload::make('photo')
                    ->label(__('erp.photo'))
                    ->image()
                    ->directory('products'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=P&color=D2B48C&background=231414'),
                Tables\Columns\TextColumn::make('name_translations.en')
                    ->label(__('erp.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->copyable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('erp.type'))
                    ->badge()
                    ->colors([
                        'success' => 'storable',
                        'warning' => 'consumable',
                        'info' => 'service',
                    ]),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label(__('erp.sale_price'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('erp.active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('erp.updated'))
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'storable' => __('erp.storable'),
                        'service' => __('erp.service'),
                        'consumable' => __('erp.consumable'),
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('erp.active')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => \App\Filament\Resources\ProductResource\Pages\ListProducts::route('/'),
            'create' => \App\Filament\Resources\ProductResource\Pages\CreateProduct::route('/create'),
            'edit' => \App\Filament\Resources\ProductResource\Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
