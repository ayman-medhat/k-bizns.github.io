<?php

namespace App\Filament\Resources;

use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    // protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'erp.nav.projects';
    protected static ?int $navigationSort = 1;

    public static function getLabel(): string
    {
        return __('erp.project');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.projects');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.project_details'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('erp.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('client_id')
                        ->label(__('erp.client'))
                        ->relationship('client', 'name')
                        ->searchable()
                        ->preload(),
                ]),
                Forms\Components\Textarea::make('description')
                    ->label(__('erp.description'))
                    ->rows(3),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\DatePicker::make('start_date')
                        ->label(__('erp.start_date')),
                    Forms\Components\DatePicker::make('end_date')
                        ->label(__('erp.end_date')),
                    Forms\Components\Select::make('status')
                        ->label(__('erp.status'))
                        ->options([
                            'planning' => __('erp.planning'),
                            'active' => __('erp.active'),
                            'on_hold' => __('erp.on_hold'),
                            'completed' => __('erp.completed'),
                            'cancelled' => __('erp.cancelled'),
                        ])
                        ->default('planning')
                        ->required(),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('budget')
                        ->label(__('erp.budget'))
                        ->numeric()
                        ->prefix('$'),
                    Forms\Components\Select::make('manager_id')
                        ->label(__('erp.manager'))
                        ->relationship('manager', 'name')
                        ->searchable()
                        ->preload(),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('erp.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->label(__('erp.client'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager.name')
                    ->label(__('erp.manager'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('erp.start_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('erp.end_date'))
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('erp.status'))
                    ->badge()
                    ->colors([
                        'info' => 'planning',
                        'primary' => 'active',
                        'warning' => 'on_hold',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'planning' => __('erp.planning'),
                        'active' => __('erp.active'),
                        'on_hold' => __('erp.on_hold'),
                        'completed' => __('erp.completed'),
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
            'index' => \App\Filament\Resources\ProjectResource\Pages\ListProjects::route('/'),
            'create' => \App\Filament\Resources\ProjectResource\Pages\CreateProject::route('/create'),
            'edit' => \App\Filament\Resources\ProjectResource\Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
