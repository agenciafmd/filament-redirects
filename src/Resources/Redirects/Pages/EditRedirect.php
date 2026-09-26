<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Resources\Redirects\Pages;

use Agenciafmd\Admix\Resources\Concerns\RedirectBack;
use Agenciafmd\Redirects\Models\Redirect;
use Agenciafmd\Redirects\Resources\Redirects\RedirectResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

final class EditRedirect extends EditRecord
{
    use RedirectBack;

    protected static string $resource = RedirectResource::class;

    /**
     * @var array<int, string>
     */
    protected $listeners = [
        'auditRestored',
    ];

    public function getRelationManagers(): array
    {
        $record = $this->getRecord();

        if ($record instanceof Redirect && $record->trashed()) {
            return [];
        }

        return parent::getRelationManagers();
    }

    public function auditRestored(): void
    {
        $this->fillForm();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
