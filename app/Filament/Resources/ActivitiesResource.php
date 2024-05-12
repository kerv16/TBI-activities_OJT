<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivitiesResource\Pages;
use App\Filament\Resources\ActivitiesResource\RelationManagers;
use App\Models\Activities;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;


class ActivitiesResource extends Resource
{
    protected static ?string $model = Activities::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Inclusive Dates')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('Date_from')
                            ->required()
                            ->format('Y-m-d')
                            ->firstDayOfWeek(0)
                            ->displayFormat('F j, Y'),
                        DatePicker::make('Date_to')
                            ->required()
                            ->format('Y-m-d')
                            ->firstDayOfWeek(0)
                            ->displayFormat('F j, Y'),
                    ]),
                Section::make('Activity Details')
                    ->columns(2)
                    ->schema([
                        Select::make('TBI_Activity')
                            ->required()
                            ->placeholder('Select an activity')
                            ->label('TBI Activity')
                            ->options([
                                'Navigatu' => 'Navigatu',
                                'CaragaRISE' => 'CaragaRISE',
                                'Tara Agri-Aqua' => 'Tara Agri-Aqua',
                            ]),
                        TextInput::make('purpose')
                            ->required(),
                        TextInput::make('conducted_by')
                            ->required(),
                        TextInput::make('participants')
                            ->required(),
                        TextInput::make('invitation_email'),
                        TextInput::make('reference_slip'),
                        TextInput::make('t_o')
                            ->label('T.O if any')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Date_from')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('Date_to')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('TBI_Activity')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('purpose')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('conducted_by')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('participants')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('invitation_email')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('reference_slip')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('t_o')
                    ->label('T.O if any')
                    ->searchable()
                    ->sortable(),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivities::route('/create'),
            'edit' => Pages\EditActivities::route('/{record}/edit'),
        ];
    }    
}
