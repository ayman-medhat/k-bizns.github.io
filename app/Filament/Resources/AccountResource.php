<?php

namespace App\Filament\Resources;

use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;
    // protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'erp.nav.accounting';
    protected static ?int $navigationSort = 1;

    public static function getLabel(): string
    {
        return __('erp.account');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.accounts');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.account_details'))->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('code')
                        ->label(__('erp.code'))
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Forms\Components\TextInput::make('name')
                        ->label(__('erp.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('type')
                        ->label(__('erp.type'))
                        ->options([
                            'asset' => __('erp.asset'),
                            'liability' => __('erp.liability'),
                            'equity' => __('erp.equity'),
                            'revenue' => __('erp.revenue'),
                            'expense' => __('erp.expense'),
                        ])
                        ->required(),
                ]),
                Forms\Components\Textarea::make('description')
                    ->label(__('erp.description'))
                    ->rows(3),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('parent_id')
                        ->label(__('erp.parent_account'))
                        ->relationship('parent', 'name')
                        ->searchable()
                        ->preload(),
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
                Tables\Columns\TextColumn::make('code')
                    ->label(__('erp.code'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('erp.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('erp.type'))
                    ->badge()
                    ->colors([
                        'success' => 'asset',
                        'danger' => 'liability',
                        'warning' => 'equity',
                        'info' => 'revenue',
                        'gray' => 'expense',
                    ]),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('erp.parent_account'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('erp.active'))
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'asset' => __('erp.asset'),
                        'liability' => __('erp.liability'),
                        'equity' => __('erp.equity'),
                        'revenue' => __('erp.revenue'),
                        'expense' => __('erp.expense'),
                    ]),
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
            'index' => \App\Filament\Resources\AccountResource\Pages\ListAccounts::route('/'),
            'create' => \App\Filament\Resources\AccountResource\Pages\CreateAccount::route('/create'),
            'edit' => \App\Filament\Resources\AccountResource\Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
