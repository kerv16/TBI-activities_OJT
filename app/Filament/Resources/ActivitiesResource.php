<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivitiesResource\Pages;
use App\Models\Post;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;

class ActivitiesResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function getLabel(): string
    {
        return 'Activity';
    }

    public static function getPluralLabel(): string
    {
        return 'Activities';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Inclusive Dates')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('Date_from')->required(),
                        DatePicker::make('Date_to')->required(),
                    ]),
                    Section::make('Activity Details')
                    ->columns(2)
                    ->schema([
                        Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->options(function () {
                                return Category::all()->pluck('title', 'id');
                            })
                            ->label('TBI Category')
                            ->required(),
                        TextInput::make('purpose')->required(),
                        TextInput::make('conducted_by')->required(),
                        TextInput::make('participants')->required(),
                        TextInput::make('invitation_email'),
                        TextInput::make('reference_slip'),
                        TextInput::make('t_o')->label('T.O (if any)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('author.name')->sortable()->searchable(),
                TextColumn::make('published_at')->date('Y-m-d')->sortable()->searchable(),
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