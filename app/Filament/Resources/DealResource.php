<?php

namespace App\Filament\Resources;

use App\Models\Deal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;
    // protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'erp.nav.crm';
    protected static ?int $navigationSort = 3;

    public static function getLabel(): string
    {
        return __('erp.deal');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.deals');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('erp.deal_details'))->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title')->label(__('erp.title'))->required()->maxLength(255),
                        Forms\Components\TextInput::make('value')->label(__('erp.value'))->numeric()->required(),
                        Forms\Components\Select::make('client_id')->label(__('erp.client'))->relationship('client', 'name')->searchable()->required(),
                        Forms\Components\Select::make('status')->label(__('erp.status'))->options([
                            'prospecting' => __('erp.prospecting'),
                            'qualification' => __('erp.qualification'),
                            'proposal' => __('erp.proposal'),
                            'negotiation' => __('erp.negotiation'),
                            'closed_won' => __('erp.closed_won'),
                            'closed_lost' => __('erp.closed_lost'),
                        ])->required(),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label(__('erp.title'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('client.name')->label(__('erp.client'))->searchable(),
                Tables\Columns\TextColumn::make('value')->label(__('erp.value'))->money()->sortable(),
                Tables\Columns\TextColumn::make('status')->label(__('erp.status'))->badge(),
            ])
            ->filters([])
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
            'index' => \App\Filament\Resources\DealResource\Pages\ListDeals::route('/'),
            'create' => \App\Filament\Resources\DealResource\Pages\CreateDeal::route('/create'),
            'edit' => \App\Filament\Resources\DealResource\Pages\EditDeal::route('/{record}/edit'),
        ];
    }
}
