<?php
global $cgu;
$GLOBALS['PAGE_TITLE'] = 'Manage Terms of Use';
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
            foreach ($cgu as $elem) :
                $i++;
            ?>
                <tr>
                    <td><?= $elem['cgu_id'] ?></td>
                    <td>
                        <textarea name="title" rows="1"><?= $elem['title'] ?></textarea>
                    </td>
                    <td>
                        <textarea name="content" rows="8"><?= $elem['content'] ?></textarea>
                    </td>
                    <td>
                        <form>
                            <input type="hidden" name="cgu_id" value="<?= $elem['cgu_id'] ?>">
                            <input type="submit" value="Update" onclick="update_cgu(event)" />
                        </form>

                    </td>
                    <td>
                        <form>
                            <input type="hidden" name="cgu_id" value="<?= $elem['cgu_id'] ?>">
                            <input type="submit" value="Delete" onclick="delete_cgu(event)" />
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>

            <tr>
                <td>Add new Term of Use</td>
                <td>
                    <textarea name="title" rows="1">Title</textarea>
                </td>
                <td>
                    <textarea name="content" rows="8">Content</textarea>
                </td>
                <td>-</td>
                <td>
                    <form>
                        <input type="submit" value="Add" onclick="add_cgu(event)" />
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</main>

<script>
    function add_cgu(event) {
        event.preventDefault();

        let title = $(event.target).closest('tr').find('textarea[name="title"]').val();
        let content = $(event.target).closest('tr').find('textarea[name="content"]').val();

        $.post(DOMAIN_NAME + '/cgu/add', {
            title: title,
            content: content
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }

    function update_cgu(event) {
        event.preventDefault();

        let cgu_id = $(event.target).closest('tr').find('input[name="cgu_id"]').val();
        let title = $(event.target).closest('tr').find('textarea[name="title"]').val();
        let content = $(event.target).closest('tr').find('textarea[name="content"]').val();

        $.post(DOMAIN_NAME + '/cgu/update', {
            cgu_id: cgu_id,
            title: title,
            content: content
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }

    function delete_cgu(event) {
        event.preventDefault();

        let cgu_id = $(event.target).closest('tr').find('input[name="cgu_id"]').val();

        $.post(DOMAIN_NAME + '/cgu/delete', {
            cgu_id: cgu_id
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }
</script>

<?php
require_view('view/footer.php');
?>