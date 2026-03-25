<?php

namespace App\Filament\Resources;

use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    // protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'erp.nav.projects';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.task');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.tasks');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.task_details'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('erp.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('project_id')
                        ->label(__('erp.project'))
                        ->relationship('project', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),
                Forms\Components\Textarea::make('description')
                    ->label(__('erp.description'))
                    ->rows(3),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\DatePicker::make('due_date')
                        ->label(__('erp.due_date')),
                    Forms\Components\Select::make('status')
                        ->label(__('erp.status'))
                        ->options([
                            'todo' => __('erp.todo'),
                            'in_progress' => __('erp.in_progress'),
                            'review' => __('erp.review'),
                            'done' => __('erp.done'),
                        ])
                        ->default('todo')
                        ->required(),
                    Forms\Components\Select::make('priority')
                        ->label(__('erp.priority'))
                        ->options([
                            'low' => __('erp.low'),
                            'medium' => __('erp.medium'),
                            'high' => __('erp.high'),
                            'urgent' => __('erp.urgent'),
                        ])
                        ->default('medium')
                        ->required(),
                ]),
                Forms\Components\Select::make('assignee_id')
                    ->label(__('erp.assignee'))
                    ->relationship('assignee', 'name')
                    ->searchable()
                    ->preload(),
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
                Tables\Columns\TextColumn::make('project.name')
                    ->label(__('erp.project'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignee.name')
                    ->label(__('erp.assignee'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('erp.due_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('erp.status'))
                    ->badge()
                    ->colors([
                        'gray' => 'todo',
                        'primary' => 'in_progress',
                        'warning' => 'review',
                        'success' => 'done',
                    ]),
                Tables\Columns\TextColumn::make('priority')
                    ->label(__('erp.priority'))
                    ->badge()
                    ->colors([
                        'info' => 'low',
                        'warning' => 'medium',
                        'danger' => 'high',
                        'danger' => 'urgent',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->relationship('project', 'name')
                    ->label(__('erp.project')),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'todo' => __('erp.todo'),
                        'in_progress' => __('erp.in_progress'),
                        'review' => __('erp.review'),
                        'done' => __('erp.done'),
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
            'index' => \App\Filament\Resources\TaskResource\Pages\ListTasks::route('/'),
            'create' => \App\Filament\Resources\TaskResource\Pages\CreateTask::route('/create'),
            'edit' => \App\Filament\Resources\TaskResource\Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
