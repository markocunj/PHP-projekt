<?php
print '
    <main>
      <div class="container">
        <h1>Contact Form</h1>
        <hr />
        <div id="contact">
          <iframe
            src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJOcwCyZLWZUcRisL7KJYkRTo&key=AIzaSyBr493WZ0Pm9liYQNwd-ytvo2gVmO5Grgc"
            width="100%"
            height="400"
            frameborder="0"
            style="border:0"
            allowfullscreen
          ></iframe>
          <hr />
          <div class="row justify-content-center text-center">
            <div class="col-md-6">
              <div class="card mb-3">
                <div class="card-body">
                  <form
                    action="http://work2.eburza.hr/pwa/responzive-page/send-contact.php"
                    id="contact_form"
                    name="contact_form"
                    method="POST"
                    class="form-group"
                  >
                    <label for="fname">First Name *</label>
                    <input
                      type="text"
                      id="fname"
                      name="firstname"
                      placeholder="Your name.."
                      class="form-control"
                      required
                    />

                    <label for="lname">Last Name *</label>
                    <input
                      type="text"
                      id="lname"
                      name="lastname"
                      placeholder="Your last name.."
                      class="form-control"
                      required
                    />

                    <label for="lname">Your E-mail *</label>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      placeholder="Your e-mail.."
                      class="form-control"
                      required
                    />

                    <label for="country">Country</label>
                    <select class="form-control" id="country" name="country">
                      <option value="">Please select</option>
                      <option value="BE">Belgium</option>
                      <option value="HR" selected>Croatia</option>
                      <option value="LU">Luxembourg</option>
                      <option value="HU">Hungary</option>
                    </select>

                    <label for="subject">Subject</label>
                    <textarea
                      id="subject"
                      name="subject"
                      placeholder="Write something.."
                      style="height:200px"
                      class="form-control"
                    ></textarea>

                    <input
                      type="submit"
                      class="btn btn-outline-success mt-2"
                      value="Submit"
                    />
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>';
?>
