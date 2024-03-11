<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
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

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Content')->schema(
                    [
                        TextInput::make('title')
                            ->live()
                            ->required()->minLength(1)->maxLength(150)
                            ->placeholder('Paste your title here') // Add placeholder to title
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord: true)->maxLength(150)
                            ->readonly(true), // Make slug field read-only
                        RichEditor::make('body')
                            ->required()
                            ->fileAttachmentsDirectory('posts/images')->columnSpanFull()
                            ->placeholder('Insert text here and attach files needed.'),
                        TextInput::make('number_of_participants')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('event_type')->required()
                    ]
                )->columns(2),
                Section::make('Meta')->schema(
                    [
                        FileUpload::make('image')->image()->directory('posts/thumbnails')->required(),
                        DateTimePicker::make('published_at')->required(),
                        Forms\Components\Hidden::make('user_id')
                            ->default(Auth::id()),
                        Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->options(function () {
                                return Category::all()->pluck('title', 'id');
                            })
                            ->label('Project Categories') // Change label to 'Project Categories'
                    ]
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('published_at')->date('Y-m-d')->sortable()->searchable(),
                ImageColumn::make('image'),
                TextColumn::make('title')->sortable()->searchable()->sortable(),
                TextColumn::make('slug')->sortable()->searchable()->sortable(),
                TextColumn::make('author.name')->sortable()->searchable(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
