<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$pdo = get_db();
$user = current_user();

$id = (int)($_GET['id'] ?? 0);
$item = ['id'=>0,'title'=>'','excerpt'=>'','body'=>'','image'=>'','status'=>'draft','author_id'=>$user['id'],'review_note'=>null];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if (!$found) { flash('error','Article not found.'); header('Location: news.php'); exit; }
    if (!can_edit_item($user, $found)) { flash('error',"You don't have permission to edit that item."); header('Location: news.php'); exit; }
    $item = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $title   = trim($_POST['title']   ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $body    = trim($_POST['body']    ?? '');
    $action  = $_POST['form_action']  ?? 'draft';

    if ($title === '') $errors[] = 'Title is required.';
    if ($body  === '') $errors[] = 'Article body is required.';

    $imagePath = $item['image'];
    try {
        $up = handle_upload('image', 'news', ['jpg','jpeg','png','webp'], 5);
        if ($up) { if ($imagePath) @unlink(__DIR__.'/../'.$imagePath); $imagePath = $up; }
    } catch (RuntimeException $e) { $errors[] = $e->getMessage(); }

    if (!$errors) {
        $status = resolve_save_status($action, $user);
        $slug   = make_slug($title, $id);

        if ($id) {
            $sql = "UPDATE news SET title=?,slug=?,excerpt=?,body=?,image=?,status=?,updated_at=NOW()";
            $p   = [$title,$slug,$excerpt,$body,$imagePath,$status];
            if ($status==='published') { $sql.=",reviewed_by=?,published_at=COALESCE(published_at,NOW()),review_note=NULL"; $p[]=$user['id']; }
            $sql.=" WHERE id=?"; $p[]=$id;
            $pdo->prepare($sql)->execute($p);
            log_activity($user,'updated news',$title);
        } else {
            $sql = "INSERT INTO news (title,slug,excerpt,body,image,status,author_id".($status==='published'?',reviewed_by,published_at':'').") VALUES (?,?,?,?,?,?,?".($status==='published'?',?,NOW()':'').")";
            $p   = [$title,$slug,$excerpt,$body,$imagePath,$status,$user['id']];
            if ($status==='published') $p[]=$user['id'];
            $pdo->prepare($sql)->execute($p);
            $id = (int)$pdo->lastInsertId();
            log_activity($user,'created news',$title);
        }

        $msg = match($status) {
            'pending'   => 'Submitted for Editor review.',
            'approved'  => 'Approved — waiting for Chief Editor to publish.',
            'published' => 'Published to the live site.',
            default     => 'Saved as draft.',
        };
        flash('success', $msg);
        header('Location: news.php'); exit;
    }
}

$pageTitle = $id ? 'Edit Article' : 'New Article';
$activeNav = 'news';
require __DIR__ . '/includes/header.php';
?>

<a href="news.php" class="text-sm text-on-surface-variant hover:text-primary flex items-center gap-1 mb-4">
  <span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to News
</a>

<?php if ($errors): ?>
  <div class="mb-5 bg-error-container text-on-error-container text-sm rounded-lg px-4 py-3">
    <ul class="list-disc pl-5"><?php foreach ($errors as $err) echo '<li>'.e($err).'</li>'; ?></ul>
  </div>
<?php endif; ?>

<?php if ($item['status'] === 'rejected' && $item['review_note']): ?>
  <div class="mb-5 bg-error-container text-on-error-container text-sm rounded-lg px-4 py-3 flex items-start gap-2">
    <span class="material-symbols-outlined text-[18px] shrink-0">feedback</span>
    <div><strong>Reviewer feedback:</strong> <?= e($item['review_note']) ?></div>
  </div>
<?php elseif ($item['status'] === 'pending'): ?>
  <div class="mb-5 bg-secondary-container text-on-secondary-container text-sm rounded-lg px-4 py-3 flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">pending</span>
    This article is currently with the Editor for review. You may still edit it.
  </div>
<?php elseif ($item['status'] === 'approved'): ?>
  <div class="mb-5 bg-tertiary-container text-on-tertiary-container text-sm rounded-lg px-4 py-3 flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">thumb_up</span>
    Approved by an Editor — waiting for the Chief Editor to publish.
  </div>
<?php endif; ?>

<!-- Workflow guide -->
<div class="mb-6 bg-surface-container-low rounded-xl px-5 py-4 flex flex-wrap gap-4 text-xs text-on-surface-variant items-center">
  <span class="font-semibold text-on-surface text-sm">Workflow:</span>
  <span class="flex items-center gap-1"><span class="w-5 h-5 rounded-full bg-surface-container-high flex items-center justify-center text-[10px] font-bold">1</span> Sub Editor saves draft &amp; submits</span>
  <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
  <span class="flex items-center gap-1"><span class="w-5 h-5 rounded-full bg-tertiary-container flex items-center justify-center text-[10px] font-bold">2</span> Editor approves</span>
  <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
  <span class="flex items-center gap-1"><span class="w-5 h-5 rounded-full bg-primary-container flex items-center justify-center text-[10px] font-bold">3</span> Chief Editor publishes</span>
</div>

<form method="post" enctype="multipart/form-data" class="bg-white border border-outline-variant rounded-xl p-6 max-w-3xl">
  <?= csrf_field() ?>

  <label class="block text-sm font-medium mb-1">Title</label>
  <input name="title" required value="<?= e($item['title']) ?>"
         class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <label class="block text-sm font-medium mb-1">Excerpt <span class="text-on-surface-variant font-normal">(short summary shown on the News listing page)</span></label>
  <textarea name="excerpt" rows="2" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none"><?= e($item['excerpt']) ?></textarea>

  <label class="block text-sm font-medium mb-1">Article body</label>
  <textarea name="body" rows="12" required class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none"><?= e($item['body']) ?></textarea>

  <label class="block text-sm font-medium mb-1">Cover image</label>
  <?php if ($item['image']): ?>
    <img src="../<?= e($item['image']) ?>" class="h-24 rounded-lg mb-2 object-cover">
  <?php endif; ?>
  <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="w-full mb-6 text-sm">

  <!-- Role-aware action buttons -->
  <div class="flex flex-wrap gap-3 pt-4 border-t border-outline-variant items-center">
    <!-- Always available -->
    <button type="submit" name="form_action" value="draft"
            class="px-4 py-2 rounded-lg border border-outline-variant text-sm font-semibold hover:bg-surface-container-low">
      Save as draft
    </button>

    <?php if ($user['role'] === 'sub_editor'): ?>
      <button type="submit" name="form_action" value="submit"
              class="px-4 py-2 rounded-lg bg-secondary-container text-on-secondary-container text-sm font-semibold hover:opacity-90">
        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">send</span> Submit for Editor review</span>
      </button>

    <?php elseif ($user['role'] === 'editor'): ?>
      <button type="submit" name="form_action" value="approve"
              class="px-4 py-2 rounded-lg bg-tertiary-container text-on-tertiary-container text-sm font-semibold hover:opacity-90">
        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">thumb_up</span> Save &amp; Approve</span>
      </button>

    <?php else: /* chief_editor */ ?>
      <button type="submit" name="form_action" value="publish"
              class="px-4 py-2 rounded-lg bg-primary text-on-primary text-sm font-semibold hover:opacity-90">
        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">rocket_launch</span> Save &amp; Publish</span>
      </button>
    <?php endif; ?>

    <?php if ($id): ?>
      <a href="preview.php?type=news&id=<?= $id ?>" target="_blank"
         class="ml-auto px-4 py-2 rounded-lg border border-outline-variant text-sm font-semibold hover:bg-surface-container-low flex items-center gap-1.5 text-on-surface-variant">
        <span class="material-symbols-outlined text-[18px]">preview</span> Preview
      </a>
    <?php endif; ?>
  </div>

  <?php if ($user['role'] !== 'chief_editor'): ?>
    <p class="mt-3 text-xs text-on-surface-variant">
      <?php if ($user['role'] === 'sub_editor'): ?>
        After you submit, an <strong>Editor</strong> will review and then a <strong>Chief Editor</strong> publishes. You cannot publish directly.
      <?php else: ?>
        After you approve, the <strong>Chief Editor</strong> publishes. You cannot publish directly.
      <?php endif; ?>
    </p>
  <?php endif; ?>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
