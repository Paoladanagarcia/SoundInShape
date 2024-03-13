<?php
global $legal;
$GLOBALS['PAGE_TITLE'] = 'Manage Legal Information';
$GLOBALS['NO_AJAX'] = true;
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<main>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Content</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($legal as $elem) :
                $i++;
            ?>
                <tr>
                    <td><?= $elem['legal_id'] ?></td>
                    <td>
                        <textarea name="title" rows="1"><?= $elem['title'] ?></textarea>
                    </td>
                    <td>
                        <textarea name="content" rows="8"><?= $elem['content'] ?></textarea>
                    </td>
                    <td>
                        <form>
                            <input type="hidden" name="legal_id" value="<?= $elem['legal_id'] ?>">
                            <input type="submit" value="Update" onclick="update_legal(event)" />
                        </form>

                    </td>
                    <td>
                        <form>
                            <input type="hidden" name="legal_id" value="<?= $elem['legal_id'] ?>">
                            <input type="submit" value="Delete" onclick="delete_legal(event)" />
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>

            <tr>
                <td>Add new legal information</td>
                <td>
                    <textarea name="title" rows="1">Title</textarea>
                </td>
                <td>
                    <textarea name="content" rows="8">Content</textarea>
                </td>
                <td>-</td>
                <td>
                    <form>
                        <input type="submit" value="Ajouter" onclick="add_legal(event)" />
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</main>

<script>
    function add_legal(event) {
        event.preventDefault();

        let title = $(event.target).closest('tr').find('textarea[name="title"]').val();
        let content = $(event.target).closest('tr').find('textarea[name="content"]').val();

        $.post(DOMAIN_NAME + '/legal/add', {
            title: title,
            content: content
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }

    function update_legal(event) {
        event.preventDefault();

        let legal_id = $(event.target).closest('tr').find('input[name="legal_id"]').val();
        let title = $(event.target).closest('tr').find('textarea[name="title"]').val();
        let content = $(event.target).closest('tr').find('textarea[name="content"]').val();

        $.post(DOMAIN_NAME + '/legal/update', {
            legal_id: legal_id,
            title: title,
            content: content
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }

    function delete_legal(event) {
        event.preventDefault();

        let legal_id = $(event.target).closest('tr').find('input[name="legal_id"]').val();

        $.post(DOMAIN_NAME + '/legal/delete', {
            legal_id: legal_id
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }
</script>

<?php
require_view('view/footer.php');
?>