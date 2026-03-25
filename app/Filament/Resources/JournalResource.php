<?php

namespace App\Filament\Resources;

use App\Models\Journal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;
    // protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'erp.nav.accounting';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.journal');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.journals');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.journal_details'))->schema([
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
                            'general' => __('erp.general'),
                            'sales' => __('erp.sales'),
                            'purchase' => __('erp.purchase'),
                            'cash' => __('erp.cash'),
                            'bank' => __('erp.bank'),
                        ])
                        ->default('general')
                        ->required(),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('default_account_id')
                        ->label(__('erp.default_account'))
                        ->relationship('defaultAccount', 'name')
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
                        'gray' => 'general',
                        'success' => 'sales',
                        'danger' => 'purchase',
                        'warning' => 'cash',
                        'info' => 'bank',
                    ]),
                Tables\Columns\TextColumn::make('defaultAccount.name')
                    ->label(__('erp.default_account'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('erp.active'))
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'general' => __('erp.general'),
                        'sales' => __('erp.sales'),
                        'purchase' => __('erp.purchase'),
                        'cash' => __('erp.cash'),
                        'bank' => __('erp.bank'),
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
            'index' => \App\Filament\Resources\JournalResource\Pages\ListJournals::route('/'),
            'create' => \App\Filament\Resources\JournalResource\Pages\CreateJournal::route('/create'),
            'edit' => \App\Filament\Resources\JournalResource\Pages\EditJournal::route('/{record}/edit'),
        ];
    }
}
