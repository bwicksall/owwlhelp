<section class="form-selection">
  <h2 class="h4 mb-3">Select a request type</h2>

  <?php if (form_group_visible('account_management')): ?>
  <div class="group-shell mb-4">
    <h3 class="group-title">Account Management</h3>
    <div class="row g-3">
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=new">
          <span class="selection-title">Request a new user account</span>
          <span class="selection-desc">Create an email account and optional Evergreen/AD access.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=modify">
          <span class="selection-title">Modify a user account</span>
          <span class="selection-desc">Request targeted changes to existing email, Evergreen, or AD account details.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=delete">
          <span class="selection-title">Delete an account</span>
          <span class="selection-desc">Submit account deprovisioning details with optional 60-day email forwarding.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=overdrive">
          <span class="selection-title">OverDrive account merge</span>
          <span class="selection-desc">Submit a patron last name and new card number to request an account merge.</span>
        </a>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <?php if (form_group_visible('admin')): ?>
  <div class="group-shell <?= form_group_visible('account_management') ? 'mt-4' : 'mb-4' ?>">
    <h3 class="group-title">Admin</h3>
    <div class="row g-3">
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=delivery">
          <span class="selection-title">Delivery questions</span>
          <span class="selection-desc">Submit delivery-related administrative questions.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=admin">
          <span class="selection-title">Other admin questions</span>
          <span class="selection-desc">Submit other administrative questions to the admin team.</span>
        </a>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <?php if (form_group_visible('central_library')): ?>
  <div class="group-shell mt-4">
    <h3 class="group-title">Central Library</h3>
    <div class="row g-3">
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=reference">
          <span class="selection-title">Ask a reference question</span>
          <span class="selection-desc">Send an information, subject, training, or other reference request.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=cba">
          <span class="selection-title">Request a CBA purchase</span>
          <span class="selection-desc">Submit author/title and optional citation details for a purchase request.</span>
        </a>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <?php if (form_group_visible('cataloging')): ?>
  <div class="group-shell mt-4">
    <h3 class="group-title">Cataloging</h3>
    <div class="row g-3">
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=catalog_issue">
          <span class="selection-title">Report a catalog issue</span>
          <span class="selection-desc">Submit catalog record problems including title errors, merges, and field corrections.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=original_cataloging">
          <span class="selection-title">Request original cataloging</span>
          <span class="selection-desc">Provide title, material details, and summary for new original cataloging records.</span>
        </a>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <?php if (form_group_visible('evergreen')): ?>
  <div class="group-shell mt-4">
    <h3 class="group-title">Evergreen</h3>
    <div class="row g-3">
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=evergreen_issue">
          <span class="selection-title">Report an Evergreen issue</span>
          <span class="selection-desc">Submit Evergreen issues by problem type with a detailed issue description.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=new_copy_location">
          <span class="selection-title">Request new copy location</span>
          <span class="selection-desc">Request a new copy location with OPAC visibility, holdable, and circulate settings.</span>
        </a>
      </div>
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=report_request">
          <span class="selection-title">Request a report</span>
          <span class="selection-desc">Request standard reports or provide details for a custom report request.</span>
        </a>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <?php if (form_group_visible('tech_support')): ?>
  <div class="group-shell mt-4">
    <h3 class="group-title">Tech Support</h3>
    <div class="row g-3">
      <div class="col-md-6">
        <a class="selection-card" href="index.php?form=general_support">
          <span class="selection-title">General support</span>
          <span class="selection-desc">Submit a general technical support request with subject and detailed description.</span>
        </a>
      </div>
    </div>
  </div>
  <?php endif; ?>
</section>
