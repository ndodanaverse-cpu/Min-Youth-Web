<?php
/**
 * Renders workflow action buttons for one content row.
 * Set $wItem (the DB row), $wType (content type string for preview),
 * $wEditUrl (href for the edit link), before including this file.
 */
$wStatus = $wItem['status'];
$wId     = (int)$wItem['id'];
$wCanReject = (can_approve($user) && $wStatus === 'pending')
           || (is_chief_editor($user) && $wStatus === 'approved');
?>
<div class="flex items-center justify-end gap-1 flex-wrap">

  <?php if (can_edit_item($user, $wItem)): ?>
    <a href="<?= e($wEditUrl) ?>" class="p-1.5 rounded hover:bg-surface-container-high" title="Edit">
      <span class="material-symbols-outlined text-[18px]">edit</span>
    </a>
  <?php endif; ?>

  <a href="preview.php?type=<?= urlencode($wType) ?>&id=<?= $wId ?>" target="_blank"
     class="p-1.5 rounded hover:bg-surface-container-high" title="Preview">
    <span class="material-symbols-outlined text-[18px]">preview</span>
  </a>

  <?php /* Sub editor: submit */ ?>
  <?php if ($user['role']==='sub_editor'
         && (int)$wItem['author_id']===(int)$user['id']
         && in_array($wStatus,['draft','rejected'],true)): ?>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $wId ?>"><input type="hidden" name="action" value="submit">
      <button class="p-1.5 rounded hover:bg-secondary-container" title="Submit for Editor review">
        <span class="material-symbols-outlined text-[18px]">send</span>
      </button>
    </form>
  <?php endif; ?>

  <?php /* Editor + Chief Editor: approve pending */ ?>
  <?php if (can_approve($user) && $wStatus==='pending'): ?>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $wId ?>"><input type="hidden" name="action" value="approve">
      <button class="p-1.5 rounded hover:bg-tertiary-container text-on-tertiary-container" title="Approve — forward to Chief Editor">
        <span class="material-symbols-outlined text-[18px]">thumb_up</span>
      </button>
    </form>
  <?php endif; ?>

  <?php /* Chief Editor ONLY: publish */ ?>
  <?php if (can_publish($user) && in_array($wStatus,['approved','pending'],true)): ?>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $wId ?>"><input type="hidden" name="action" value="publish">
      <button class="p-1.5 rounded hover:bg-primary-container text-primary" title="Publish to live site">
        <span class="material-symbols-outlined text-[18px]">rocket_launch</span>
      </button>
    </form>
  <?php endif; ?>

  <?php /* Reject */ ?>
  <?php if ($wCanReject): ?>
    <button type="button"
            onclick="document.getElementById('rej-<?= $wType.'-'.$wId ?>').classList.toggle('hidden')"
            class="p-1.5 rounded hover:bg-error-container text-error" title="Reject with feedback">
      <span class="material-symbols-outlined text-[18px]">undo</span>
    </button>
  <?php endif; ?>

  <?php /* Chief Editor: unpublish */ ?>
  <?php if (can_publish($user) && $wStatus==='published'): ?>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $wId ?>"><input type="hidden" name="action" value="unpublish">
      <button class="p-1.5 rounded hover:bg-surface-container-high" title="Unpublish">
        <span class="material-symbols-outlined text-[18px]">visibility_off</span>
      </button>
    </form>
  <?php endif; ?>

  <?php /* Chief Editor: delete */ ?>
  <?php if (can_delete($user)): ?>
    <form method="post" onsubmit="return confirm('Delete permanently?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $wId ?>"><input type="hidden" name="action" value="delete">
      <button class="p-1.5 rounded hover:bg-error-container text-error" title="Delete">
        <span class="material-symbols-outlined text-[18px]">delete</span>
      </button>
    </form>
  <?php endif; ?>
</div>

<?php if ($wCanReject): ?>
  <form method="post" id="rej-<?= $wType.'-'.$wId ?>" class="hidden mt-2 flex gap-2">
    <?= csrf_field() ?><input type="hidden" name="id" value="<?= $wId ?>"><input type="hidden" name="action" value="reject">
    <input name="review_note" placeholder="Reason for rejection…" required
           class="flex-1 text-xs border border-outline-variant rounded px-2 py-1 focus:ring-1 focus:ring-error outline-none">
    <button class="text-xs font-semibold text-error whitespace-nowrap">Send back</button>
  </form>
<?php endif; ?>
