<?php

namespace App\Filament\Resources;

use App\Models\BOM;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BOMResource extends Resource
{
    protected static ?string $model = BOM::class;
    // protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'erp.nav.manufacturing';
    protected static ?int $navigationSort = 1;

    public static function getLabel(): string
    {
        return __('erp.bom');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.boms');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make(__('erp.bom_details'))->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('reference')
                            ->label(__('erp.reference'))
                            ->default(fn() => BOM::generateNumber())
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Forms\Components\Select::make('product_id')
                            ->label(__('erp.product'))
                            ->relationship('product', 'name_translations->en')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label(__('erp.quantity'))
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ]),
                ]),

                Forms\Components\Section::make(__('erp.bom_items'))->schema([
                    Forms\Components\Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\Select::make('component_product_id')
                                    ->label(__('erp.component'))
                                    ->relationship('component', 'name_translations->en')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('quantity')
                                    ->label(__('erp.quantity'))
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                            ]),
                        ])
                        ->defaultItems(1)
                        ->columns(1),
                ]),
            ])->columnSpan(['lg' => 3]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label(__('erp.reference'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name_translations.en')
                    ->label(__('erp.product'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('erp.quantity'))
                    ->numeric(),
            ])
            ->filters([
                //
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
            'index' => \App\Filament\Resources\BOMResource\Pages\ListBOMs::route('/'),
            'create' => \App\Filament\Resources\BOMResource\Pages\CreateBOM::route('/create'),
            'edit' => \App\Filament\Resources\BOMResource\Pages\EditBOM::route('/{record}/edit'),
        ];
    }
}
