<?php

namespace App\Filament\Resources;

use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;
    // protected static ?string $navigationIcon = 'heroicon-o-funnel';
    protected static ?string $navigationGroup = 'erp.nav.crm';
    protected static ?int $navigationSort = 4;

    public static function getLabel(): string
    {
        return __('erp.lead');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.leads');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('erp.lead_details'))->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('first_name')->label(__('erp.first_name'))->required()->maxLength(255),
                        Forms\Components\TextInput::make('last_name')->label(__('erp.last_name'))->nullable()->maxLength(255),
                        Forms\Components\TextInput::make('email')->label(__('erp.email'))->email()->nullable()->maxLength(255),
                        Forms\Components\TextInput::make('phone')->label(__('erp.phone'))->tel()->nullable()->maxLength(255),
                        Forms\Components\TextInput::make('company_name')->label(__('erp.company_name'))->nullable()->maxLength(255),
                        Forms\Components\TextInput::make('source')->label(__('erp.source'))->nullable()->maxLength(255),
                        Forms\Components\TextInput::make('value')->label(__('erp.value'))->numeric()->nullable(),
                        Forms\Components\Select::make('status')->label(__('erp.status'))->options([
                            'new' => __('erp.new'),
                            'contacted' => __('erp.contacted'),
                            'qualified' => __('erp.qualified'),
                            'lost' => __('erp.lost'),
                            'converted' => __('erp.converted'),
                        ])->default('new')->required(),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('erp.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('company_name')->label(__('erp.company_name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label(__('erp.email'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('erp.phone'))->searchable(),
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
            'index' => \App\Filament\Resources\LeadResource\Pages\ListLeads::route('/'),
            'create' => \App\Filament\Resources\LeadResource\Pages\CreateLead::route('/create'),
            'edit' => \App\Filament\Resources\LeadResource\Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
