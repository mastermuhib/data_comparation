"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _validations = [];

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
			_validations[wizard.getStep() - 1].validate().then(function (status) {
				if (status == 'Valid') {
					_wizard.goNext();
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});

			_wizard.stop();  // Don't go to the next step
		});

		// Change event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1
        let a =FormValidation.formValidation(
			_formEl,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'name is required'
							}
						}
					},
					email: {
						validators: {
							notEmpty: {
								message: 'email is required'
                            },
                            emailAddress: {
                                message: 'The input is not a valid email address'
                            }
						}
					},


                    password: {
                        validators: {
                            notEmpty: {
                                enabled: true,
                                message: 'The password is required and cannot be empty'
                            }
                        }
                    },
                    confirmPassword: {
                        validators: {
                            notEmpty: {
                                enabled: true,
                                message: 'The confirm password is required and cannot be empty'
                            },
                            identical: {
                                enabled: true,
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm must be the same',
                            }
                        }
                    },
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
            }

        );
        _formEl.querySelector('[name="password"]').addEventListener('input', function() {
            a.revalidateField('confirmPassword');
        });
            // Enable the password/confirm password validators if the password is not empty
        let enabled = false;
        _formEl.querySelector('[name="password"]').addEventListener('input', function(e) {
            const password = e.target.value;
            if (password === '' && enabled) {
                enabled = false;
                a.disableValidator('password').disableValidator('confirmPassword');
            } else if (password != '' && !enabled) {
                enabled = true;
                a.enableValidator('password').enableValidator('confirmPassword');
            }

            // Revalidate the confirmation password when the new password is changed
            if (password != '' && enabled) {
                a.revalidateField('confirmPassword');
            }
        });
		_validations.push(a);

         // Revalidate the confirmation password when changing the password


		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					foto_profile: {
						validators: {
							notEmpty: {
								message: 'Package details is required'
							}
						}
					},
                    ktp: {
                            validators: {
                                notEmpty: {
                                    message: 'No KTP is required'
                                },
                                stringLength: {
                                    min: 16,
                                    max: 16,
                                    message: 'NO KTP harus 16 digit'
                                },
                            }
                        },
                    npwp: {
                        validators: {
                            stringLength: {
                                min: 15,
                                max: 15,
                                message: 'NO NPWP harus 15 digit'
                            },
                        }
                    },

                    nohp: {
                            validators: {
                                notEmpty: {
                                    message: 'Phone Number is required'
                                },
                                regexp: {
                                    regexp: /\+?([ -]?\d+)+|\(\d+\)([ -]\d+)/,
                                    message: 'Nomor Harus tipe +62 ...'
                                }
                            }
                        },
                    alamat_ktp: {
                        validators: {
                            notEmpty: {
                                message: 'alamat_ktp is required'
                            }
                        }
                    },
                    alamat_domisili: {
                        validators: {
                            notEmpty: {
                                message: 'alamat_domisili is required'
                            }
                        }
                    },
                    gender: {
                        validators: {
                            notEmpty: {
                                message: 'gender is required'
                            }
                        }
                    },
                    tgl_lahir: {
                        validators: {
                            notEmpty: {
                                message: 'tgl_lahir is required'
                            }
                        }
                    },
					body_height: {
						validators: {
							notEmpty: {
								message: 'Tinggi Badan is required'
							},
							digits: {
								message: 'The value added is not valid'
							}
						}
					},
					body_weight: {
						validators: {
							notEmpty: {
								message: 'Berat Badan is required'
							},
							digits: {
								message: 'The value added is not valid'
							}
						}
					},
					agama: {
						validators: {
							notEmpty: {
								message: 'Agama is required'
							}
						}
					},
					status_pernikahan: {
						validators: {
							notEmpty: {
								message: 'status_pernikahan is required'
							}
						}
					},
					kacamata: {
						validators: {
							notEmpty: {
								message: 'Mata Sehat is required'
							}
						}
					},

				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					delivery: {
						validators: {
							notEmpty: {
								message: 'Delivery type is required'
							}
						}
					},
					packaging: {
						validators: {
							notEmpty: {
								message: 'Packaging type is required'
							}
						}
					},
					preferreddelivery: {
						validators: {
							notEmpty: {
								message: 'Preferred delivery window is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					locaddress1: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
					locpostcode: {
						validators: {
							notEmpty: {
								message: 'Postcode is required'
							}
						}
					},
					loccity: {
						validators: {
							notEmpty: {
								message: 'City is required'
							}
						}
					},
					locstate: {
						validators: {
							notEmpty: {
								message: 'State is required'
							}
						}
					},
					loccountry: {
						validators: {
							notEmpty: {
								message: 'Country is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard_v1');
            _formEl = KTUtil.getById('form_add');


			initWizard();
			initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard1.init();
});
